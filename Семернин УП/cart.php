<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="assets/css/cont.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery first, then Popper.js, then Bootstrap JS -->

</head>
<body>

<style>

      h1 {
      text-align: center;
        }
        table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    background-color: transparent; /* Сделать фон таблицы прозрачным */
    
}

th, td {
    
    padding: 8px;
    text-align: left;
    background-color: rgba(255, 255, 255, 0.5); /* Прозрачный цвет фона столбцов */
}

.quantity-button {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background-color: #ccc;
    color: #000;
    text-align: center;
    line-height: 25px;
}

.quantity-button:hover {
    background-color: #aaa;
}

</style>

<div class="container">
    <h1>Корзина</h1>
    
    <?php
    session_start();
// Подключение к базе данных
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "test";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Получаем товары из корзины для текущего пользователя
    if (!isset($_SESSION['user_id'])) {
      // Если пользователь не авторизован, выводим сообщение об ошибке и завершаем скрипт
      echo "<script>alert('Чтобы пользоваться корзиной, нужно быть авторизованным.')</script>";
      exit();
  }

  $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare("SELECT cart.product_id, products.name, products.img, cart.quantity, products.price FROM cart INNER JOIN products ON cart.product_id = products.id WHERE cart.user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($cart_items)) {
        echo "<p style='text-align: center;'>Ваша корзина пуста.</p>";
    } else {
        // Выводим товары в корзине
        echo "<form method='post' action='update_cart.php'>";
        echo "<table>";
        echo "<tr><th>Изображение</th><th>Название товара</th><th>Цена за единицу</th><th>Количество</th><th>Сумма</th></tr>";
        foreach ($cart_items as $item) {
            echo "<tr>";
            echo "<td><img src='{$item['img']}' alt='{$item['name']}' style='width: 50px; height: 50px;'></td>";
            echo "<td>{$item['name']}</td>";
            echo "<td>{$item['price']} руб.</td>";
            
            echo "<td class='count-cell' style='padding-top: 22px; text-align: center; display: flex;'>";
            echo "<span class='quantity-button minus' style='cursor: pointer; margin-right: 10px; user-select: none;'>-</span>";
            echo "<input type='number' name='quantity[{$item['product_id']}]' value='{$item['quantity']}' min='1' style='width: 50px; text-align: center;'>";
            echo "<span class='quantity-button plus' style='cursor: pointer; margin-left: 10px; user-select: none;'>+</span>";
            echo "</td>";


            echo "<td>" . number_format(floatval($item['quantity']) * floatval($item['price']), 2) . " руб.</td>";



            echo "<td><button class='delete-button' data-product-id='{$item['product_id']}'>Удалить</button></td>";

            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";

        // Подсчет общей стоимости корзины
        $total_price = 0;
        foreach ($cart_items as $item) {
            $total_price += $item['quantity'] * $item['price'];
        }
        echo "<div style='text-align: right; margin-top: 20px;' id='total-price'>Общая стоимость корзины: <span id='total-price-value'>" . $total_price . "</span> руб.</div>";            
    }
} catch(PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>
</div>




<script>
    // Функция для отправки формы при изменении количества товаров
    function submitForm() {
        document.querySelector('form').submit();
    }

    // Находим все поля ввода количества товаров
    var quantityInputs = document.querySelectorAll('input[name^="quantity["]');
    // Привязываем обработчик события изменения значения к каждому полю ввода
    quantityInputs.forEach(function(input) {
        input.addEventListener('change', submitForm);
    });


    document.addEventListener("DOMContentLoaded", function() {
    var quantityButtons = document.querySelectorAll(".quantity-button");
    
    quantityButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var input = this.parentNode.querySelector("input[type='number']");
            var currentValue = parseInt(input.value);
            if (this.classList.contains("minus")) {
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            } else if (this.classList.contains("plus")) {
                input.value = currentValue + 1;
            }
            submitForm(); // После изменения количества отправляем форму
        });
    });
});


document.addEventListener("DOMContentLoaded", function() {
    var deleteButtons = document.querySelectorAll(".delete-button");
    
    deleteButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var productId = this.getAttribute('data-product-id');
            deleteCartItem(productId);
        });
    });
});

function deleteCartItem(productId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_cart_item.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Обновляем содержимое корзины на странице
                updateCartContent();
            } else {
                // Обработка ошибки удаления
                console.error(response.error);
            }
        }
    };
    xhr.send("product_id=" + productId);
}

function updateCartContent() {
    // Обновляем содержимое корзины на странице
    // Ваш код для обновления содержимого корзины
}

</script>




</body>
</html>