<?php
session_start();

// Функция для проверки, является ли пользователь администратором (замените логикой из вашей системы)
function isUserAdmin($userId) {
    // Ваша логика проверки, например, из базы данных
    // Верните true, если пользователь администратор, в противном случае false
    return ($userId === "Admin1523");
}

// Проверяем, является ли текущий пользователь администратором
$userIsAdmin = false;

// Предположим, что у вас есть идентификатор пользователя в сессии (замените это соответствующим кодом)
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($userId) {
    $userIsAdmin = isUserAdmin($userId);
}
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
            color: #ffffff;
        }

        header {
            background-color: #212529;
        }

        header img {
            max-width: 100%;
        }

        header .nav-link {
            color: #ffffff;
        }

        header .btn-light {
            color: #fff;
            background-color: #343a40;
        }

        header .btn-light:hover {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        footer {
            background-color: #212529;
            color: #ffffff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .divider-top {
            border-bottom: 5px solid #dc3545;
            margin-top: 20px;
        }

        .divider-bottom {
            border-bottom: 5px solid #dc3545;
            margin-bottom: 40px;
        }

        .img-slider {
            max-height: 650px;
            object-fit: cover;
        }

        .dropdown .btn-light {
            color: #212529;
            background-color: #343a40;
        }

        .dropdown .btn-light:hover {
            background-color: #f8f9fa;
        }

        .dropdown-menu .dropdown-item {
            color: #212529;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown {
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <a href="<?php echo ($userIsAdmin ? 'admin_panel.php' : 'index.php'); ?>">
                        <img src="logo.svg" alt="Логотип" class="img-fluid">
                    </a>
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
                    if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
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
                        echo '<a href="login.php" class="btn btn-light">Вход</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Разделительная линия -->
    <div class="divider-top"></div>

    <!-- Слайдер -->
    <div id="mainSlider" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            // Пример слайдов
            $slideImages = ["1234.jpg", "5678.jpg", "890.jpg"];
            foreach ($slideImages as $index => $image) {
                echo '<div class="carousel-item';
                // Делаем первый слайд активным
                if ($index === 0) {
                    echo ' active';
                }
                echo '">
                        <img src="' . $image . '" class="d-block w-100 img-slider" alt="Слайд ' . ($index + 1) . '">
                      </div>';
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#mainSlider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#mainSlider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Заголовок страницы -->
    <div class="container mt-4">
        <h1 class="text-center">Популярные товары!</h1>
    </div>

    <!-- Контент страницы -->
    <div class="container mt-4">
        <div class="row">
            <?php
            // Пример блока продукта 1
            echo '<div class="col-md-4 mb-4">
                    <img src="helden.jpg" alt="Продукт 1" class="img-fluid">
                    <h3>Шампунь HEAD&SHOULDERS®, Уход за сухой кожей головы, 400мл</h3>
                    <p>Краткое описание продукта. Преимущества и особенности.</p>
                    <a button class="btn btn-primary" href-"product.php"> Купить сейчас</button> </a>
                  </div>';

            // Пример блока продукта 2
            echo '<div class="col-md-4 mb-4">
                    <img src="product4.jpg" alt="Продукт 2" class="img-fluid">
                    <h3>Шоколад МИ ТУ Ю молочный с печеньем, 24г </h3>
                    <p>Краткое описание продукта. Преимущества и особенности.</p>
                    <a button class="btn btn-primary" href="product.php"> Купить сейчас</button> </a>
                  </div>';

            // Пример блока продукта 3
            echo '<div class="col-md-4 mb-4">
                    <img src="promotion3.jpg" alt="Продукт 3" class="img-fluid">
                    <h3>Конфеты КОРКУНОВ Бриллиант, 90г</h3>
                    <p>Краткое описание продукта. Преимущества и особенности.</p>
                    <a button class="btn btn-primary" href="product.php"> Купить сейчас</button> </a>
                  </div>';
            ?>
        </div>
        <div class="container mt-4">
            <h1 class="text-center">Акции!</h1>
        </div>
        <div class="row">
            <?php
            // Пример блока акции 1
            echo '<div class="col-md-4 mb-4">
                    <img src="promotion1.jpg" alt="Акция 1" class="img-fluid">
                    <h2>Десерт творожный РостАгроЭкспорт глазированный в вафельном рожке два вкуса</h2>
                    <p>Купи два и получий третий в подарок.</p>
                    <button class="btn btn-warning">Участвовать</button>
                  </div>';

            // Пример блока акции 2
            echo '<div class="col-md-4 mb-4">
                    <img src="promotion2.jpg" alt="Акция 2" class="img-fluid">
                    <h2>БЗМЖ Йогурт VIOLA Very Berry с манго 2,6% 180г</h2>
                    <p>Купи два и получий третий в подарок.</p>
                    <button class="btn btn-warning">Участвовать</button>
                  </div>';

            // Пример блока акции 3
            echo '<div class="col-md-4 mb-4">
                    <img src="promotion3.jpg" alt="Акция 3" class="img-fluid">
                    <h2>Конфеты КОРКУНОВ Бриллиант, 90г
                    </h2>
                    <p>Описание акции. Преимущества и условия.</p>
                    <button class="btn btn-warning">Участвовать</button>
                  </div>';
            ?>
        </div>
        <div class="container mt-4">
            <h1 class="text-center">Новости!</h1>
        </div>
        <div class="row">
            <?php
            // Пример блока новости 1
            echo '<div class="col-md-4 mb-4">
                    <img src="news1.jpg" alt="Новость 1" class="img-fluid">
                    <h2>Новость 1</h2>
                    <p>Текст новости и дополнительная информация.</p>
                    <button class="btn btn-info">Читать</button>
                  </div>';

            // Пример блока новости 2
            echo '<div class="col-md-4 mb-4">
                    <img src="news2.jpg" alt="Новость 2" class="img-fluid">
                    <h2>Новость 2</h2>
                    <p>Текст новости и дополнительная информация.</p>
                    <button class="btn btn-info">Читать</button>
                  </div>';

            // Пример блока новости 3
            echo '<div class="col-md-4 mb-4">
                    <img src="news3.jpg" alt="Новость 3" class="img-fluid">
                    <h2>Новость 3</h2>
                    <p>Текст новости и дополнительная информация.</p>
                    <button class="btn btn-info">Читать</button>
                  </div>';
            ?>
        </div>
    </div>

    <!-- Разделительная линия -->
    <div class="divider-bottom"></div>

    <!-- Подвал страницы -->
    <footer class="footer mt-4 bg-dark text-white text-center py-2" style="height: 40px;">
        <p>&copy; 2024 Ваш сайт. Все права защищены.</p>
    </footer>

    <!-- Скрипты Bootstrap (необходимо добавить перед закрывающим тегом </body>) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>
