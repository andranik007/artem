<?php
session_start();

// Подключение к базе данных
$link = mysqli_connect("localhost", "admin", "admin", "test");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Проверка авторизации (вставьте свой код для проверки авторизации)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $price = mysqli_real_escape_string($link, $_POST['price']);

    // Обработка загружаемой картинки
    $image = $_FILES['image'];
    $imageName = time() . '_' . $image['name'];
    $imagePath = 'uploads/' . $imageName;

    move_uploaded_file($image['tmp_name'], $imagePath);

    // SQL-запрос для добавления продукта
    $addProductQuery = "INSERT INTO products (name, description, price, image_path) 
                        VALUES ('$name', '$description', '$price', '$imagePath')";

    if (mysqli_query($link, $addProductQuery)) {
        // Продукт успешно добавлен
        header("Location: product.php");
        exit();
    } else {
        // Ошибка при добавлении продукта
        echo "Error: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Добавить продукт</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            background-color: #343a40; /* Цвет фона */
            color: #ffffff; /* Цвет текста */
        }

        .container {
            margin-top: 20px; /* Отступ сверху для контейнера */
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Добавить продукт</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Название:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Цена:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="image">Изображение:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Добавить продукт</button>
        </form>
    </div>

</body>

</html>
