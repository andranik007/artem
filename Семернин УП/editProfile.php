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
    if (!empty($_POST['login']) && !empty($_POST['fio']) && !empty($_POST['email'])) {
        $login = $_POST['login'];
        $fio = $_POST['fio'];
        $email = $_POST['email'];

        // Предполагая, что у вас есть поле user_id, которое идентифицирует пользователя
        $user_id = $_SESSION['user_id'];

        // Ваш код для обновления данных профиля в базе данных
        $query = "UPDATE users SET login=?, fio=?, email=? WHERE id=?";
        $updateStatement = $pdo->prepare($query);
        $updateStatement->execute([$login, $fio, $email, $user_id]);

        echo "Профиль успешно обновлен";
    } else {
        echo "Логин, ФИО и почта не могут быть пустыми";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Редактирование профиля</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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

        form input[type="text"],
        form input[type="email"] {
            margin-bottom: 15px;
            background-color: #555;
            color: #fff;
        }

        form input[type="submit"] {
            background-color: #d9534f;
            border: 1px solid #d9534f;
        }

        form input[type="submit"]:hover {
            background-color: #c9302c;
            border: 1px solid #c9302c;
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
            <form method="post">
                <h2 class="mt-5 mb-3 text-center">Редактирование профиля</h2>

                <div class="form-group">
                    <label for="login">Новый логин</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Новый логин" required>
                </div>

                <div class="form-group">
                    <label for="fio">Новое ФИО</label>
                    <input type="text" class="form-control" id="fio" name="fio" placeholder="Новое ФИО" required>
                </div>

                <div class="form-group">
                    <label for="email">Новая почта</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Новая почта" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Сохранить изменения</button>
                
                <!-- Кнопка "Назад" -->
                <a href="index.php" class="btn btn-secondary btn-block mt-3">Назад</a>
            </form>
        </div>
    </div>
</div>

<!-- Скрипты Bootstrap (добавьте перед закрывающим тегом </body>) -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>
</html>
