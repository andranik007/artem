<?php
session_start();

// Подключение к базе данных
$link = mysqli_connect("localhost", "admin", "admin", "test");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Обработка добавления комментария
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitComment'])) {
    $comment = mysqli_real_escape_string($link, $_POST['comment']);
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!empty($comment) && !empty($userId)) {
        $addCommentQuery = "INSERT INTO comments (user_id, comment_text) VALUES ('$userId', '$comment')";
        mysqli_query($link, $addCommentQuery);

        // Перенаправление после добавления комментария
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }
}

// Получаем комментарии для отображения на странице
$commentsQuery = "SELECT comments.comment_text, users.fio 
                  FROM comments
                  JOIN users ON comments.user_id = users.id";
$commentsResult = mysqli_query($link, $commentsQuery);

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>О нас - Ваш сайт</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-ZdLzUzq+J3GiJXEe4TA6v9v8Z/Qa8CfmQYEWDq1TpJ3cMpw3g8ZmmN/2OgqjeiQRbLzA0cGOT4n7Fp2EAyfETg=="
        crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <style>
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7); /* Измените значение alpha (0.5) по вашему усмотрению */
            z-index: -1;
        }

        body {
            background: url('background_image.jpeg') center center fixed;
            background-size: cover;
            /* Добавьте остальные стили для body, если необходимо */
            color: #ffffff; /* Цвет текста */
            font-family: sans-serif; /* Используем стандартный шрифт sans-serif */
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
            color: #fff;
            /* Цвет текста кнопок */
            background-color: #343a40;
            /* Цвет фона кнопок */
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

        .divider {
            border-bottom: 2px solid #dc3545; /* Красная линия разделителя */
            margin-top: 20px; /* Отступ от линии до контента */
            margin-bottom: 20px; /* Отступ от линии до контента */
        }

        .media img {
            width: 64px; /* Установите ширину аватара по вашему усмотрению */
            height: 64px; /* Установите высоту аватара по вашему усмотрению */
            border-radius: 50%; /* Округление углов для создания круглого аватара */
        }

        /* Добавленные стили для иконки профиля */
        .profile-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
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
                                    <img src="profile.png" alt="Иконка профиля" class="profile-icon">
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

    <!-- Содержание страницы "О нас" -->
    <div class="container mt-4">
        <h1 class="text-center">Добро пожаловать на наш сайт заказа продуктов и продукции! </h1>
        <p class="text-justify">Мы рады приветствовать вас в удобном и надежном месте для заказа разнообразных продуктов и продукции. Наша компания стремится обеспечить вас высококачественными товарами, удобным сервисом и быстрой доставкой.</p>

        <h2 class="text-center mt-4">Наши продукты</h2>
        <p class="text-justify">У нас вы найдете широкий ассортимент продуктов, подходящих для любого вкуса и предпочтения. Наш ассортимент включает в себя:</p>
        <ul class="text-justify">
            <li>Свежие продукты: Фрукты, овощи, мясо, рыба и многое другое, всегда свежее и качественное.</li>
            <li>Готовые блюда: Вы можете заказать готовые блюда, приготовленные нашими опытными поварами, чтобы сэкономить время на кулинарных заботах.</li>
            <li>Продукция для здоровья: Органические и натуральные продукты, например, органические орехи, мед и зерновые продукты.</li>
        </ul>
        <h2 class="text-center mt-4">Почему выбирают нас?</h2>
        <ul class="text-justify">
            <li>Качество продукции: Мы тщательно выбираем продукты от надежных поставщиков.</li>
            <li>Безопасность: Все продукты проходят контроль качества и соответствуют стандартам безопасности.</li>
            <li>Удобство и скорость: Простой процесс заказа и оперативная доставка, чтобы вы могли наслаждаться своими покупками быстро.</li>
            <li>Отличное обслуживание клиентов: Наша команда готова ответить на ваши вопросы и помочь вам в любое время.</li>
        </ul>
    </div>

    <!-- Разделительная линия -->
    <div class="divider"></div>

    <!-- Форма и комментарии -->
    <div class="container mt-4">
        <h2 class="text-center mt-4">Комментарии пользователей</h2>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <?php
                // Выводим комментарии
                while ($row = mysqli_fetch_assoc($commentsResult)) {
                    echo '<div class="media mb-3">';
                    echo '  <img src="user_avatar.jpg" class="mr-3" alt="Аватар пользователя">';
                    echo '  <div class="media-body">';
                    echo '      <h5 class="mt-0">' . $row['fio'] . '</h5>';
                    echo '      <p>' . $row['comment_text'] . '</p>';
                    echo '  </div>';
                    echo '</div>';
                }
                ?>
                <?php
                // Проверяем, авторизован ли пользователь, чтобы отобразить форму для добавления комментария
                if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
                    echo '<form method="post" action="" class="mt-3">
                            <div class="form-group">
                                <label for="comment">Оставьте свой комментарий:</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" name="submitComment" class="btn btn-primary">Добавить комментарий</button>
                        </form>';
                } else {
                    echo '<p class="text-center">Чтобы оставить комментарий, пожалуйста, <a href="register.php">войдите</a>.</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Разделительная линия -->
    <div class="divider"></div>

    <!-- Подвал страницы -->
    <footer class="footer mt-4 bg-dark text-white text-center py-2" style="height: 40px;">
        <p>&copy; 2024 Ваш сайт. Все права защищены.</p>
    </footer>

   <!-- Скрипты Bootstrap (необходимо добавить перед закрывающим тегом </body>) -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJjFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>
