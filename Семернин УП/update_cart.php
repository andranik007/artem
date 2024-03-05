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

    // Проверяем, был ли отправлен POST-запрос
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Проверяем, существует ли сессия пользователя
        if (!isset($_SESSION['user_id'])) {
            // Если сессия не существует, выводим сообщение об ошибке и перенаправляем на страницу входа
            echo '<script>alert("Для доступа к корзине необходимо войти в аккаунт.😉"); window.location.href = "login.php";</script>';
            exit;
        }

        // Получаем ID пользователя из сессии
        $user_id = $_SESSION['user_id'];

        // Получаем данные о количестве товаров из POST-запроса
        $quantity_data = $_POST['quantity'];

        // Обновляем количество товаров в корзине
        foreach ($quantity_data as $product_id => $quantity) {
            // Подготавливаем запрос для обновления количества товаров в корзине
            $stmt = $db->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
            // Выполняем запрос, передавая параметры
            $stmt->execute(['quantity' => $quantity, 'user_id' => $user_id, 'product_id' => $product_id]);
        }

        // Перенаправляем пользователя на страницу корзины с обновленными данными
        header('Location: cart.php');
        exit;
    }
} catch(PDOException $e) {
    // В случае ошибки выводим сообщение
    echo "Ошибка: " . $e->getMessage();
}
?>
