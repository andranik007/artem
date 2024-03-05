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
    if (isset($_POST['changePassword'])) {
        // Обработка запроса на изменение пароля
        if (!empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['confirmPassword'])) {
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            // Проверка старого пароля
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM users WHERE id=?";
            $selectStatement = $pdo->prepare($query);
            $selectStatement->execute([$user_id]);
            $user = $selectStatement->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($oldPassword, $user['password'])) {
                // Старый пароль совпадает, проверка нового пароля и его подтверждение
                if ($newPassword === $confirmPassword) {
                    // Ваш код для обновления пароля в базе данных
                    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                    $updateQuery = "UPDATE users SET password=? WHERE id=?";
                    $updateStatement = $pdo->prepare($updateQuery);
                    $updateStatement->execute([$hashedPassword, $user_id]);

                    echo "Пароль успешно изменен";
                } else {
                    echo "Новый пароль и подтверждение пароля не совпадают";
                }
            } else {
                echo "Старый пароль введен неверно";
            }
        } else {
            echo "Все поля должны быть заполнены";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Изменение пароля</title>
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
            background-color: #5bc0de;
            border: 1px solid #5bc0de;
        }

        form input[type="submit"]:hover {
            background-color: #4cae4c;
            border: 1px solid #4cae4c;
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
                <h2 class="mt-5 mb-3 text-center">Изменение пароля</h2>

                <div class="form-group">
                    <label for="oldPassword">Старый пароль</label>
                    <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Старый пароль" required>
                </div>

                <div class="form-group">
                    <label for="newPassword">Новый пароль</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Новый пароль" required>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Подтвердите новый пароль</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Подтвердите новый пароль" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block" name="changePassword">Изменить пароль</button>

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
