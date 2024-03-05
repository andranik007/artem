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
    if (isset($_POST['deleteAccount'])) {
        // Обработка запроса на удаление аккаунта
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];

            // Проверка пароля
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM users WHERE id=?";
            $selectStatement = $pdo->prepare($query);
            $selectStatement->execute([$user_id]);
            $user = $selectStatement->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Ваш код для удаления аккаунта из базы данных
                $deleteQuery = "DELETE FROM users WHERE id=?";
                $deleteStatement = $pdo->prepare($deleteQuery);
                $deleteStatement->execute([$user_id]);

                // Очистка сессии и перенаправление на страницу выхода
                session_unset();
                session_destroy();
                header('Location: logout.php');
                exit();
            } else {
                echo "Неверный пароль";
            }
        } else {
            echo "Пароль обязателен для заполнения";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Удаление аккаунта</title>
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

        form input[type="password"] {
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
                <h2 class="mt-5 mb-3 text-center">Удаление аккаунта</h2>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Введите ваш пароль" required>
                </div>

                <button type="submit" class="btn btn-danger btn-block" name="deleteAccount">Удалить аккаунт</button>

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
