<?php
session_start();

$dsn = "mysql:host=localhost;dbname=test";
$username = "admin";
$password = "admin";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !empty($_POST['login']) &&
        !empty($_POST['password']) &&
        !empty($_POST['birthdate']) &&
        !empty($_POST['email']) &&
        !empty($_POST['country']) &&
        !empty($_POST['fio'])
    ) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $birthdate = $_POST['birthdate'];

        $today = new DateTime();
        $birthday = new DateTime($birthdate);
        $age = $today->diff($birthday)->y;

        if ($age < 4 || $age > 90) {
            echo "<p><b>Возраст должен быть от 4 до 90 лет.</b></p>";
            exit();
        }

        $email = $_POST['email'];
        $country = $_POST['country'];
        $fio = $_POST['fio'];

        if (!preg_match("/^[a-zA-Zа-яА-Я]+\s[a-zA-Zа-яА-Я]+\s[a-zA-Zа-яА-Я]+$/u", $fio)) {
            echo "<p><b>Фамилия, имя и отчество могут содержать только буквы и должны состоять из трех слов, разделенных пробелами.</b></p>";
            exit();
        }

        $checkLoginQuery = "SELECT * FROM users WHERE login=?";
        $checkLoginStatement = $pdo->prepare($checkLoginQuery);
        $checkLoginStatement->execute([$login]);
        $checkLoginResult = $checkLoginStatement->fetch(PDO::FETCH_ASSOC);

        $checkEmailQuery = "SELECT * FROM users WHERE email=?";
        $checkEmailStatement = $pdo->prepare($checkEmailQuery);
        $checkEmailStatement->execute([$email]);
        $checkEmailResult = $checkEmailStatement->fetch(PDO::FETCH_ASSOC);

        if ($checkLoginResult) {
            echo "<p><b>Логин уже занят. Пожалуйста, выберите другой логин.</b></p>";
        } elseif ($checkEmailResult) {
            echo "<p><b>Этот email уже используется. Пожалуйста, выберите другой email.</b></p>";
        } else {
            $role = "user"; // Здесь устанавливаем роль пользователя

            $hashPassword = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users (login, password, birthdate, email, country, fio, status_id, role)
                      VALUES (?, ?, ?, ?, ?, ?, 1, ?)";

            $insertStatement = $pdo->prepare($query);
            $insertStatement->execute([$login, $hashPassword, $birthdate, $email, $country, $fio, $role]);

            if ($insertStatement->rowCount() > 0) {
                echo "<div class='container mt-5'>
                        <div class='row justify-content-center'>
                          <div class='col-md-6'>
                            <div class='alert alert-success text-center' role='alert'>
                              Регистрация прошла успешно!
                            </div>
                            <p class='text-center'>Уже зарегистрированы? <a href='login.php'>Войти</a></p>
                          </div>
                        </div>
                      </div>";

                $userIdQuery = "SELECT id FROM users WHERE login=?";
                $userIdStatement = $pdo->prepare($userIdQuery);
                $userIdStatement->execute([$login]);
                $userIdResult = $userIdStatement->fetch(PDO::FETCH_ASSOC);
                $userId = $userIdResult['id'];

                $_SESSION['auth'] = true;
                $_SESSION['user_id'] = $userId;
                $_SESSION['login'] = $login;
                $_SESSION['status'] = 'user';
                $_SESSION['role'] = $role; // Добавляем роль в сессию
                $_SESSION['fio'] = $fio;
                $_SESSION['email'] = $email;

                header('Location: index.php');
                exit();
            } else {
                echo "<div class='container mt-5'>
                        <div class='row justify-content-center'>
                          <div class='col-md-6'>
                            <div class='alert alert-danger text-center' role='alert'>
                              Ошибка при регистрации: " . $pdo->errorInfo()[2] . "
                            </div>
                          </div>
                        </div>
                      </div>";
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Регистрация</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mt-5 mb-3 text-center">Регистрация</h2>
        <form action="" method="post">

          <div class="form-group">
            <label for="login">Логин</label>
            <input type="text" class="form-control" id="login" name="login" placeholder="от 4 до 10 символов" required>
          </div>

          <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="от 6 до 12 символов" required>
          </div>

          <div class="form-group">
            <label for="fio">ФИО</label>
            <input type="text" class="form-control" id="fio" name="fio" placeholder="Фамилия Имя Отчество" required>
          </div>

          <div class="form-group">
            <label for="mail">E-mail</label>
            <input type="text" class="form-control" id="mail" name="email" placeholder="Ваш электронный адрес" required>
          </div>

          <div class="form-group">
            <label for="birthdate">Дата рождения</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
          </div>

          <div class="form-group">
            <label for="country">Страна</label>
            <select class="form-control" id="country" name="country" required>
              <option value="Россия">Россия</option>
              <option value="Казахстан">Казахстан</option>
              <option value="Армения">Армения</option>
              <!-- Добавьте другие страны по аналогии -->
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </form>
        <p class="mt-3 text-center">Уже зарегистрированы? <a href="login.php">Войти</a></p>
      </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>



<style>
    body {
        background-color: #222;
        color: #fff;
    }

    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #000;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #333;
    }

    form input[type="submit"]:hover {
        background-color: #c9302c;
    }

    a {
        color: #d9534f;
    }

    a:hover {
        color: #c9302c;
    }
</style>
