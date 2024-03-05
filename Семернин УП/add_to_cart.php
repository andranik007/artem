<?php
session_start();

// Подключение к базе данных
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "test";

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проверяем, существует ли параметр product_id
    if (isset($_POST['product_id'])) {
        // Получаем ID товара из POST-запроса
        $product_id = $_POST['product_id'];

        // Проверяем, существует ли сессия пользователя
   
        if (!isset($_SESSION['user_id'])) {
            // Если сессия не существует, выводим сообщение об ошибке
            echo '<script>alert("Для добавления товара в корзину необходимо войти в аккаунт.😉"); window.location.href = "main.php";</script>';
            exit;
        }

        // Получаем ID пользователя из сессии
        $user_id = $_SESSION['user_id'];

        try {
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Ошибка подключения: " . $e->getMessage();
            exit;
        }

        try {
            // Подготавливаем запрос для добавления товара в корзину
            $stmt = $db->prepare('INSERT INTO cart (product_id, user_id) VALUES (:product_id, :user_id)');
            // Выполняем запрос, передавая параметры
            $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
            
            // Перенаправляем пользователя на страницу корзины
            header('Location: cart.php');
            exit;
        } catch (PDOException $e) {
            // В случае ошибки выводим сообщение
            echo "Ошибка добавления товара в корзину: " . $e->getMessage();
            exit;
        }
    }
}
?>
