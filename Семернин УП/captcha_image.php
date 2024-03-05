<?php
session_start();

header("Content-type: image/png");

// Генерация случайной строки (значения капчи)
$captcha_string = $_SESSION['captcha_result'];

// Создание изображения
$image = imagecreate(120, 40);
$background_color = imagecolorallocate($image, 33, 33, 33);
$text_color = imagecolorallocate($image, 255, 255, 255);

// Настройка шрифта (вам может потребоваться указать путь к шрифту)
$font = 'arial.ttf'; // Укажите путь к файлу ttf шрифта

// Размещение текста на изображении
imagettftext($image, 20, 0, 10, 30, $text_color, $font, $captcha_string);

// Вывод изображения
imagepng($image);

// Освобождение ресурсов
imagedestroy($image);
?>
