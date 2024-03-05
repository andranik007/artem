<?php
// Начало сессии
session_start();

// Подключение к базе данных
try {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "admin", "admin");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Проверка авторизации
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Если пользователь не авторизован, перенаправляем на страницу логина
    header('Location: login_form.php');
    exit();
}

// Получение данных пользователя из базы данных
$login = $_SESSION['login'];
$query = "SELECT login, fio, birthdate, email, country, registration_date FROM users WHERE login=?";
$stmt = $pdo->prepare($query);
$stmt->execute([$login]);

try {
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Вычисление полного возраста пользователя
    $birthdate = new DateTime($userData['birthdate']);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthdate)->y;
} catch (Exception $e) {
    die("Error fetching user data: " . $e->getMessage());
}

// Обработка формы редактирования
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, была ли отправлена форма редактирования
    if (isset($_POST['edit_mode'])) {
        // Устанавливаем флаг редактирования в сессии
        $_SESSION['edit_mode'] = true;
    } else {
        // Обрабатываем обновление данных, если форма была отправлена
        $newFio = htmlspecialchars($_POST['new_fio']);
        $newBirthdate = htmlspecialchars($_POST['new_birthdate']);
        $newEmail = htmlspecialchars($_POST['new_email']);
        $newCountry = htmlspecialchars($_POST['new_country']);

        // Обновление данных пользователя в базе данных
        $updateQuery = "UPDATE users SET fio=?, birthdate=?, email=?, country=? WHERE login=?";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([$newFio, $newBirthdate, $newEmail, $newCountry, $login]);

        // Обновление данных в сессии
        $_SESSION['fio'] = $newFio;
        $_SESSION['birthdate'] = $newBirthdate;
        $_SESSION['email'] = $newEmail;
        $_SESSION['country'] = $newCountry;

        // Сбрасываем флаг редактирования в сессии
        unset($_SESSION['edit_mode']);

        // Перезагрузка страницы после редактирования
        header("Location: profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&family=PT+Sans+Caption:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <!-- Подключите файл со стилями Bootstrap здесь -->
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <style>
    /* Ваши стили остаются без изменений */

    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Профиль пользователя</h1>
        <?php if (isset($_SESSION['edit_mode']) && $_SESSION['edit_mode'] && !empty($userData)) : ?>
            <!-- Форма редактирования профиля -->
            <form action="profile.php" method="POST">
                <!-- Оставьте форму редактирования без изменений -->
            </form>
        <?php else : ?>
            <!-- Отображение данных профиля -->
<?php if (!empty($userData) && is_array($userData)) : ?>
    <p><strong>Логин:</strong> <?php echo $userData['login']; ?></p>
    <p><strong>ФИО:</strong> <?php echo $userData['fio']; ?></p>
    <?php if (isset($age)) : ?>
        <p><strong>Возраст:</strong> <?php echo $age; ?></p>
    <?php endif; ?>
    <p><strong>Email:</strong> <?php echo $userData['email']; ?></p>
    <p><strong>Страна:</strong> <?php echo $userData['country']; ?></p>
    <p><strong>Дата регистрации:</strong> <?php echo $userData['registration_date']; ?></p>
<?php else : ?>
    <p>Данные пользователя не найдены</p>
<?php endif; ?>

        <?php endif; ?>

        <!-- Форма редактирования и кнопка "Редактировать" -->
        <?php if (!isset($_SESSION['edit_mode']) || !$_SESSION['edit_mode']) : ?>
            <!-- Оставьте форму редактирования без изменений -->
        <?php endif; ?>

        <!-- Кнопка смены пароля -->
        <a href="deleteAccount.php" class="deleteAccount-button">Удалить аккаунт</a>
        
        <!-- Кнопка смены пароля -->
        <a href="changePassword.php" class="changePassword-button">Изменить пароль</a>

        <!-- Кнопка выхода -->
        <form action="logout.php" method="post">
            <input type="submit" value="Выйти">
        </form>
    </div>

    <!-- Кнопка "Пользователи" -->
    <a href="users.php" class="users-button">Пользователи</a>

    <!-- Подключите файлы скриптов Bootstrap здесь -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
