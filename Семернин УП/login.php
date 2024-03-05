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
    if (!empty($_POST['login']) && !empty($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $query = "SELECT * FROM `users` WHERE `login`=? AND `status_id`=1";
        $selectStatement = $pdo->prepare($query);
        $selectStatement->execute([$login]);
        $row = $selectStatement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Переход к более безопасному методу хеширования (bcrypt)
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            echo $row['password'];
            echo "<br>";
            echo $hashedPassword;

            if (password_verify($password, $row['password'])) {
                $_SESSION['auth'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['login'] = $row['login'];
                $_SESSION['fio'] = $row['fio'];
                $_SESSION['email'] = $row['email'];
                
                if($row['role'] == 'admin'){
                    $_SESSION['status'] = 2;
                } elseif($row['role']  == 'user'){
                    $_SESSION['status'] = 1;
                }
                header('Location: index.php');
                exit();
            } else {
                echo "Неверный логин или пароль";
            }
        } else {
            echo "Неверный логин или пароль";
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form  method="post">
                <h2 class="mt-5 mb-3 text-center">Авторизация</h2>

                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Логин" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Пароль" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Войти</button>
                <p class="mt-3 text-center">
                    Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a>.
                </p>
            </form>
        </div>
    </div>
</div>

<!-- Скрипты Bootstrap (добавьте перед закрывающим тегом </body>) -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>