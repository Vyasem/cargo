-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 29 2017 г., 18:59
-- Версия сервера: 5.7.19-0ubuntu0.16.04.1
-- Версия PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `logistic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cargo`
--

CREATE TABLE `cargo` (
  `id` int(255) NOT NULL,
  `container` varchar(255) NOT NULL,
  `client_id` int(255) NOT NULL,
  `manager_id` int(255) NOT NULL,
  `delivery_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cargo`
--

INSERT INTO `cargo` (`id`, `container`, `client_id`, `manager_id`, `delivery_date`, `status`) VALUES
(1, 'Рис', 1, 1, '2016-12-31 21:00:00', 'Finished'),
(2, 'Запчасти', 4, 1, '2017-12-30 21:00:00', 'On board'),
(3, 'Мука', 1, 1, '2017-09-26 21:00:00', 'On board'),
(4, 'Материал', 2, 2, '2017-08-31 21:00:00', 'Finished'),
(5, 'Рыба', 3, 2, '2017-09-19 21:00:00', 'Awaiting'),
(6, 'Резиновые изделия', 4, 4, '2017-08-24 21:00:00', 'Awaiting'),
(7, 'Спиртные напитки', 5, 4, '2017-08-11 21:00:00', 'Awaiting'),
(8, 'Автомобильные запчасти', 3, 4, '2017-09-15 21:00:00', 'Awaiting'),
(9, 'Мясо', 2, 4, '2017-08-28 21:00:00', 'Awaiting'),
(10, 'Игрушки', 4, 4, '2017-09-21 21:00:00', 'Awaiting'),
(11, 'Стекло', 5, 5, '2017-08-22 09:37:18', 'Awaiting'),
(12, 'Пластик', 2, 5, '2017-09-12 21:00:00', 'Awaiting'),
(13, 'Подушки', 5, 5, '2017-09-19 21:00:00', 'Awaiting'),
(14, 'Вода', 3, 5, '2017-10-02 21:00:00', 'Awaiting'),
(15, 'Инструменты', 1, 5, '2017-08-26 21:00:00', 'Awaiting'),
(16, 'Картошка', 1, 5, '2017-08-24 21:00:00', 'Awaiting'),
(39, 'Сахар', 2, 0, '2017-08-28 14:13:18', 'Awaiting'),
(45, 'Каски', 4, 1, '2017-08-29 12:21:33', 'Awaiting'),
(46, 'Корм', 2, 0, '2017-08-28 20:39:00', 'Awaiting'),
(47, 'Булочки', 4, 1, '2017-09-02 21:00:00', 'On board'),
(48, 'Мед', 4, 2, '2017-08-29 10:18:49', 'Awaiting');

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `iin` int(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `company_name`, `iin`, `adress`, `email`, `phone`) VALUES
(1, 'FOODS CORPORATION', 586963125, 'ул. Горького 5', 'foods@foods.com', '+7 (812) 856-96-45'),
(2, 'Lenin', 854697123, 'ул. Обухова', 'lenin@test.com', '+7 (812) 458-96-36'),
(3, 'eurasian corp', 245961456, 'ул. Тракторная 15', 'eurasia@test.com', '+7 (812) 258-96-45'),
(4, 'mobile', 839237610, 'ул. Дружбы 14', 'mo@test.com', '+7 (812) 777-77-77'),
(5, 'Transport', 847127874, 'ул. Побед 312', 'transport@test.com', '+7 (812) 111-11-11'),
(6, 'EDU', 888999222, 'ул. Копеечная 43', 'edu@test.com', '+7 (812) 138-22-88'),
(7, 'Lenta', 111222333, 'ул. Конюхова 34', 'lenta@test.com', '+7 (812) 555-55-55'),
(8, 'Language', 848848848, 'ул. Серая 14', 'lang@test.com', '+7 (812) 123-456-789'),
(9, 'Fly', 784456345, 'ул. Красноармейска 29', 'fly@test.com', '+7 (812) 555-88-99'),
(10, 'Green Company', 777333444, 'ул. Первая 1', 'green@test.com', '+7 (812) 456-89-98'),
(11, 'Moda', 67898736, 'ул. Вторая 2', 'moda@test.com', '+7 (812) 555-666-33'),
(12, 'Easy Life', 456789486, 'ул. Далекая 43', 'easy@test.com', '+7 (812) 856-89-89');

-- --------------------------------------------------------

--
-- Структура таблицы `invoice`
--

CREATE TABLE `invoice` (
  `id` int(255) NOT NULL,
  `cargo_id` int(255) NOT NULL,
  `invoice` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `invoice`
--

INSERT INTO `invoice` (`id`, `cargo_id`, `invoice`) VALUES
(1, 1, '333'),
(2, 2, '444'),
(3, 5, '6666'),
(4, 6, '764'),
(5, 7, '4234'),
(6, 8, '546546'),
(7, 9, '123213'),
(8, 10, '243234'),
(9, 11, '234234'),
(10, 12, '234234'),
(11, 45, '678678');

-- --------------------------------------------------------

--
-- Структура таблицы `manager`
--

CREATE TABLE `manager` (
  `id` int(255) NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `manager`
--

INSERT INTO `manager` (`id`, `surname`, `name`, `email`, `phone`) VALUES
(1, 'Смелая', 'Наталья', 'nataly@test.com', '+7 (812) 865-89-13'),
(2, 'Анохин', 'Антон', 'anton@test.com', '+7 (812) 865-89-63'),
(4, 'Силуанов', 'Константин', 'konst@test.com', '+7(812) 856-96-36'),
(5, 'Мазур', 'Елена', 'lena@test.com', '+7(812) 869-89-96');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `login` varchar(255) NOT NULL,
  `pasword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `user_id`, `type`, `login`, `pasword`) VALUES
(1, 1, 'manager', 'nataly', '$2y$10$aIo2Li0knPncozKHJOcmTuJJz/prXjb1A53WJ8ktPWf5t1gJWtHi2'),
(2, 2, 'manager', 'anton', '$2y$10$1TzkbKNzFpx6FH6a3OL3g.lJPRLQ6cocbIMH0nriGbfrkZnCYf/My'),
(3, 4, 'manager', 'konst', '$2y$10$uNweHUOMC5YPD4pgcvBwcObwgfVgNEeUpyXqReMFj5YzFHIwgs8aq'),
(4, 5, 'manager', 'lena', '$2y$10$zOJVq1IW1NZZ0/G9./5sOOv29aBjMmwUdkETex69WqnAKKbGUaCXy'),
(5, 1, 'clients', 'foods', '$2y$10$8LxViZQeO1046nsbV8rJm.LnIHDdbRCrckb8fgPyis0FoXrEBYqri'),
(6, 2, 'clients', 'lenin', '$2y$10$1mEh49riQQ2wT0r0cwQvs.KGdsxDDe3CTYThHJKf5KRGW1jDSW8AC'),
(7, 3, 'clients', 'eurasian', '$2y$10$7wzegodyMZb2d8g.pxfGK.dqQNaHdGrJ14jBGf46ThnHTdymF6h1O'),
(8, 4, 'clients', 'mobile', '$2y$10$yUMaAasba1IbjK0ierpriu5A7b3bZDPIkqpspkxOu3nxSZBAC991a'),
(9, 5, 'clients', 'transport', '$2y$10$QMIwSLVnPHdiSpmQJs32ouU1Lw8vQ4gCBo2OJfxbXQI9ci0aNqTnO');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `manager`
--
ALTER TABLE `manager`
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
-- AUTO_INCREMENT для таблицы `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
