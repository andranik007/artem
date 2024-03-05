-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 01 2024 г., 14:25
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `captcha`
--

CREATE TABLE `captcha` (
  `id` int(11) NOT NULL,
  `captcha_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `captcha`
--

INSERT INTO `captcha` (`id`, `captcha_value`) VALUES
(1, 'tBIZrQ'),
(2, 'lBVQpZ'),
(3, 'PJxyhu'),
(4, 'aBwqJH'),
(5, 'Xxzjed'),
(6, 'PWKoFL'),
(7, 'BJnrWz'),
(8, 'YkvEeD'),
(9, 'jbbnMm'),
(10, 'qfYakm'),
(11, 'somGHu'),
(12, 'aiWmNY'),
(13, 'ADbOcV'),
(14, 'HKmeqU'),
(15, 'MMOwPW'),
(16, 'tqRJjD'),
(17, 'pGyrzq');

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `comment_text`, `created_at`) VALUES
(29, 8, 'ывпврвапвап', '2024-02-26 13:32:24'),
(30, 8, 'магазин вообще топчик, купил почку себе и детям ', '2024-02-29 11:30:30'),
(36, 8, 'вфы H&lt;br/&gt;ell<script&gt;alert(document.cookie)&lt;/script&gt;', '2024-02-29 12:04:12'),
(37, 8, 'dfas H&It;br/&gt;ell<script&gt;alert(document.cookie)&It;/script&gt;', '2024-02-29 12:04:36'),
(38, 8, '— Есть, шо выпить?\r\n— Выпить-то есть, а вот есть нет.', '2024-03-01 13:24:18'),
(39, 8, 'КТО В КАКОМ КЛАССЕ УЧИЛСЯ? - Я В А. - О И Я В А. - А Я В Б. - А Я И В А И В Б', '2024-03-01 13:24:54');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_path`, `img`) VALUES
(2, 'бум бум', 'бам бам ', '12.00', 'uploads/1708595723_promotion3.jpg', NULL),
(3, 'бум бум', 'бам бам ', '1.50', 'uploads/1708595749_promotion2.jpg', NULL),
(4, 'dfgdfg', 'sdfsdf', '1.00', 'uploads/1708597953_1106090181.png', NULL),
(5, 'бум бум', 'афыва', '1.99', 'uploads/1708598860_promotion1.jpg', NULL),
(6, 'бум бум', 'бум бум', '1.00', 'uploads/1708598881_1000268709.png', NULL),
(7, 'нк4еркенркерк', 'еркеркркерк', '1000.00', 'uploads/1708955420_1106090181.png', NULL),
(9, 'Губозакаточная машинка ', 'Чтобы Андраник не пел ', '0.00', 'uploads/1708955808_7137.0x400-transformed.png', NULL),
(10, 'Часы Ben 10 Омнитрикс. Сезон 3', 'Супер пупер игрушка для вашего ребенка', '6.00', 'uploads/1708955885_6000362002-transformed.png', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `salt`, `birthdate`, `email`, `country`, `fio`, `status_id`, `role`, `registration_date`) VALUES
(2, 'User123', '6c18744cb124c654233f08ae9855c827', '$Apt_%3Ov~\"Pg]^1J8.?S_zE?u;LR-3oCEz\"Z}Cf,3-pxg^O)Fsv]LnA<5RhhXqn=94(Qi(Vj6&Wh&~<)Re/;T19n$`a}llO9fQ', '2004-12-22', 'asd@asdadsфы', 'Россия', 'Семернин Артем Витальевич', 2, 'admin', '2024-02-21 12:51:35'),
(6, 'Admin123', '$2y$10$9l6ADG5MkQLh96fQizyJUexOVi56qmVyaTPH1IiJcM1HXgmuxLke2', '', '2004-12-22', 'Admin123@mail.ru', 'Россия', 'Семернин Артем Витальевич', 1, 'user', '2024-02-21 13:14:25'),
(8, 'Admin1523', '$2y$10$sVFTOTGfDxQC74FLZJkywO4D9HMlPi/w3rZFJHmHL7SqZghznKwUC', '', '2004-12-22', 'so.zatvordfgnik.lo@gmail.com', 'Россия', 'Семернин Артем Витальевич', 1, 'admin', '2024-02-22 08:13:53'),
(9, 'обычный юзер', '$2y$10$K/.hmHZXm88KSSk.biTVuOklV5QM2bKl9XnSRCc8.13sJ9WBoIL2m', '', '2004-12-22', 'so.zatfdvornik.lo@gmail.com', 'Россия', 'Семернин Артем Витальевич', 1, 'user', '2024-02-22 10:48:56'),
(10, 'Se7En', '$2y$10$NmScDEfCDFCrPQmT30iFn.BMtYSoyccJn3KPdVqkC2nW/PBj63KSe', '', '2004-12-22', 'Se7Enagd@asdads', 'Россия', 'Семернин Артем Витальевич', 1, 'admin', '2024-02-26 14:01:50');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `captcha`
--
ALTER TABLE `captcha`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `captcha`
--
ALTER TABLE `captcha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
