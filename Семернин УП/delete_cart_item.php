<?php
// Подключение к базе данных
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "test";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Получение идентификатора товара для удаления из параметров запроса
    $product_id = $_POST['product_id'];
    
    // Выполнение SQL-запроса для удаления товара из корзины
    $stmt = $db->prepare("DELETE FROM cart WHERE product_id = :product_id");
    $stmt->execute(['product_id' => $product_id]);
    
    // Возвращаем успешный ответ
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    // Возвращаем сообщение об ошибке, если что-то пошло не так
    echo json_encode(['error' => 'Ошибка: ' . $e->getMessage()]);
}
?>
