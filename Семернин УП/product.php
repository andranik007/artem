<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Подключение к базе данных
$link = mysqli_connect("localhost", "admin", "admin", "test");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Проверка, авторизован ли пользователь
$isAdmin = isset($_SESSION['auth']) && $_SESSION['auth'] && $_SESSION['status'] === 'admin';
$isEditor = isset($_SESSION['auth']) && $_SESSION['auth'] && $_SESSION['status'] === 'editor';

// Запрос на получение всех товаров
$productQuery = "SELECT * FROM products";
$productResult = mysqli_query($link, $productQuery);

// Проверка наличия товаров
if (!$productResult) {
    die("Error retrieving products: " . mysqli_error($link));
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ваш сайт</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-ZdLzUzq+J3GiJXEe4TA6v9v8Z/Qa8CfmQYEWDq1TpJ3cMpw3g8ZmmN/2OgqjeiQRbLzA0cGOT4n7Fp2EAyfETg==" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            background-color: #343a40;
            /* Цвет фона */
            color: #ffffff;
            /* Цвет текста */
        }

        header {
            background-color: #212529;
            /* Цвет фона шапки профиля */
        }

        header img {
            max-width: 100%;
            /* Сделаем логотип адаптивным */
        }

        header .nav-link {
            color: #ffffff;
            /* Цвет текста ссылок в навигации */
        }

        header .btn-light {
            color: #fff;
            /* Цвет текста кнопок */
            background-color: #343a40;
            /* Цвет фона кнопок */
        }

        header .btn-light:hover {
            background-color: #f8f9fa;
            /* Цвет фона кнопок при наведении */
        }

        .container {
            margin-top: 20px;
            /* Отступ сверху для контейнера */
        }

        footer {
            background-color: #212529;
            /* Цвет фона подвала */
            color: #ffffff;
            /* Цвет текста подвала */
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .divider {
            border-bottom: 2px solid #dc3545;
            /* Красная линия разделителя */
            margin-top: 20px;
            /* Отступ от линии до контента */
            margin-bottom: 20px;
            /* Отступ от линии до контента */
        }
    </style>
</head>

<body>

    <!-- Шапка профиля -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="logo.svg" alt="Логотип" class="img-fluid">
                </div>
                <div class="col-md-8 text-center">
                    <nav class="nav justify-content-center">
                        <a class="nav-link" href="index.php">Главная страница</a>
                        <a class="nav-link" href="product.php">Товары</a>
                        <a class="nav-link" href="about.php">О нас</a>
                    </nav>
                </div>
                <div class="col-md-2 text-right">
                    <?php
                    // Проверяем авторизацию пользователя
                    if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
                        // Выводим круглую картинку вместо текста кнопки "Профиль"
                        echo '<div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="profile.png" alt="Иконка профиля" class="rounded-circle" style="width: 30px; height: 30px;">
                                </button>
                                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="#">Логин: ' . $_SESSION['login'] . '</a>
                                    <a class="dropdown-item" href="#">ФИО: ' . $_SESSION['fio'] . '</a>
                                    <a class="dropdown-item" href="#">Email: ' . $_SESSION['email'] . '</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="editProfile.php">Редактировать профиль</a>
                                    <a class="dropdown-item" href="changePassword.php">Изменить пароль</a>
                                    <a class="dropdown-item" href="deleteAccount.php">Удалить аккаунт</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="login.php">Выйти</a>
                                </div>
                            </div>';
                    } else {
                        // Выводим кнопку "Вход"
                        echo '<a href="login.php" class="btn btn-light">Вход</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Разделительная линия -->
    <div class="divider"></div>

    <!-- Заголовок страницы -->
    <div class="container mt-4">
        <h1 class="text-center">Все товары магазина</h1>
    </div>

    <!-- Контент страницы -->
    <div class="container mt-4">
        <div class="row">
        <?php
// Вывод блоков с товарами
while ($row = mysqli_fetch_assoc($productResult)) {
    echo '<div class="col-md-4 mb-4">
            <img src="' . $row['image_path'] . '" alt="Продукт ' . $row['id'] . '" class="img-fluid">
            <h3>' . $row['name'] . '</h3>
            <p>' . $row['description'] . '</p>
            <p><strong>Цена: Руб ' . $row['price'] . '</strong></p>';

    // Проверка наличия дополнительных полей и роли администратора
    if ($isAdmin && isset($row['additional_fields'])) {
        echo '<p>Дополнительные поля: ' . $row['additional_fields'] . '</p>';
    }

    echo "<form method='post' action='add_to_cart.php'>";
    echo "<input type='hidden' name='product_id' value='{$row['id']}'>";
    echo "<button type='submit' class='btn btn-primary'>Добавить в корзину</button>";
    echo "</form>";

    echo '</div>';
}
?>



     
        </div>
    </div>

    <!-- Разделительная линия -->
    <div class="divider"></div>

    <!-- Подвал страницы -->
    <footer class="footer mt-4 bg-dark text-white text-center py-2">
        <p>&copy; 2024 Ваш сайт. Все права защищены.</p>
    </footer>

    <!-- Скрипты Bootstrap (необходимо добавить перед закрывающим тегом </body>) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>
