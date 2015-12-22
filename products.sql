-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 12 2015 г., 18:20
-- Версия сервера: 5.5.46-0ubuntu0.14.04.2
-- Версия PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `shopmvc7`
--

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `body` text NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `manf_id` int(11) DEFAULT NULL,
  `images` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `author`, `title`, `description`, `body`, `price`, `cat_id`, `manf_id`, `images`) VALUES
(1, 'Пушкин', 'Руслан и Людмила', 'бум бум', 'опять бум бум', 100.20, NULL, NULL, NULL),
(2, 'Лермонтов', 'Фигня на ровном месте', 'описание', 'розширене описание', 99.00, 1, 1, NULL),
(3, 'онегин', 'ьезценный твор', 'описание', 'развернутое описание', 55.00, 1, 1, NULL),
(4, 'Гете', 'Фауст', 'описание', 'разверутое описание', 30.00, 1, 1, NULL),
(5, 'Гейна', 'Какаято муть', 'описание', 'еще одно оисание', 44.00, 1, 1, NULL),
(6, 'Жириновский', 'Майн камф с самим собой', 'описание ', 'снова описание', 1.00, 1, 1, NULL),
(7, 'Хующенко', 'Помаранч без прикрас', 'опис', 'ще опис', 40.00, 1, 1, NULL),
(8, 'Ленин', 'Собрание трудов', 'опис ', 'розширеный опыс ', 10000.00, 1, 1, NULL),
(9, 'Ленин в. И', 'розширеное собрание трудоа', 'опис', 'розвернутий опыс', 200.00, 1, 1, NULL),
(10, 'Носов', 'полет на луну', 'опыс', 'ще раз опис', 300.00, 1, 1, NULL),
(11, 'Чфн дзи минь', 'Китай как дракон', 'опис ', 'розшпреный опис', 100.00, 1, 1, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
