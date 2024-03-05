<?php
session_start();

// Проверяем, является ли текущий пользователь администратором
function isUserAdmin($userId) {
    // Ваша логика проверки, например, из базы данных
    // Верните true, если пользователь администратор, в противном случае false
    return ($userId === "Admin1523");
}

// Предположим, что у вас есть идентификатор пользователя в сессии (замените это соответствующим кодом)
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Проверяем, является ли текущий пользователь администратором
if ($userId && isUserAdmin($userId)) {
    // Пользователь администратор, позволяем доступ к админ-панели
    echo '
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Админ-панель</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-ZdLzUzq+J3GiJXEe4TA6v9v8Z/Qa8CfmQYEWDq1TpJ3cMpw3g8ZmmN/2OgqjeiQRbLzA0cGOT4n7Fp2EAyfETg==" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            body {
                background-color: #343a40; /* Цвет фона */
                color: #ffffff; /* Цвет текста */
            }
    
            header {
                background-color: #212529; /* Цвет фона шапки профиля */
            }
    
            header img {
                max-width: 100%; /* Сделаем логотип адаптивным */
            }
    
            header .nav-link {
                color: #ffffff; /* Цвет текста ссылок в навигации */
            }
    
            header .btn-light {
                color: #fff; /* Цвет текста кнопок */
                background-color: #343a40; /* Цвет фона кнопок */
            }
    
            header .btn-light:hover {
                background-color: #f8f9fa; /* Цвет фона кнопок при наведении */
            }
    
            .container {
                margin-top: 20px; /* Отступ сверху для контейнера */
            }
    
            footer {
                background-color: #212529; /* Цвет фона подвала */
                color: #ffffff; /* Цвет текста подвала */
                position: fixed;
                bottom: 0;
                width: 100%;
            }
    
            .divider-top {
                border-bottom: 5px solid #dc3545; /* Красная линия разделителя */
                margin-top: 20px /* Отступ от линии до контента */
            }
    
            .divider-bottom {
                border-bottom: 5px solid #dc3545; /* Красная линия разделителя */
                margin-bottom: 40px; /* Отступ от линии до контента */
    
            }
    
            /* Стиль для уменьшения размера картинок слайдера */
            .img-slider {
                max-height: 650px; /* Задайте максимальную высоту, которая вам нужна */
                object-fit: cover; /* Заполняет контейнер, сохраняя соотношение сторон и обрезая изображение */
            }
    
            /* Стили для кнопки Профиль */
            .dropdown .btn-lig {
                color: #212529; /* Цвет текста кнопки Профиль */
                background-color: #343a40; /* Цвет фона кнопки Профиль */
            }
    
            .dropdown .btn-light:hover {
                background-color: #f8f9fa; /* Цвет фона кнопки Профиль при наведении */
            }
    
            .dropdown-menu .dropdown-item {
                color: #212529; /* Цвет текста пунктов выпадающего списка */
            }
    
            .dropdown-menu .dropdown-item:hover {
                background-color: #f8f9fa; /* Цвет фона пункта выпадающего списка при наведении */
            }
    
            /* Стиль для иконки профиля */
            .dropdown {
                border-radius: 50%;
                object-fit: cover;
            }
        </style>
    </head>
    
    <body>
    
        <!-- Шапка админ-панели -->
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <img src="logo.svg" alt="Логотип" class="img-fluid">
                    </div>
                    <div class="col-md-10 text-right">
                        <a href="logout.php" class="btn btn-light">Выйти</a>
                    </div>
                </div>
            </div>
        </header>
    
        <!-- Контент админ-панели -->
        <div class="container mt-4">
            <h1 class="text-center">Добро пожаловать в админ-панель, <?php echo $_SESSION['login']; ?>!</h1>
            <!-- Ваш код для админ-панели здесь -->
        </div>
    
        <!-- Подвал админ-панели -->
        <footer class="footer mt-4 bg-dark text-white text-center py-2" style="height: 40px;">
            <p>&copy; 2024 Ваш сайт. Все права защищены.</p>
        </footer>
    
        <!-- Скрипты Bootstrap (необходимо добавить перед закрывающим тегом </body>) -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    </body>
    
    </html>';
} else {
    // Пользователь не является администратором, перенаправляем его на главную страницу
    header("Location: index.php");
    exit();
}
?>
