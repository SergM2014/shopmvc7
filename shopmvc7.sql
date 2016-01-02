-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 02 2016 г., 13:18
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
-- Структура таблицы `background`
--

CREATE TABLE IF NOT EXISTS `background` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `about` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `background`
--

INSERT INTO `background` (`id`, `about`) VALUES
(1, 'Der Text ueber Uns Allen\r\nWir sind aber gut');

-- --------------------------------------------------------

--
-- Структура таблицы `carousel`
--

CREATE TABLE IF NOT EXISTS `carousel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `carousel`
--

INSERT INTO `carousel` (`id`, `image`, `url`) VALUES
(1, 'bodybottom.gif', '/'),
(2, 'bodymidl.gif', '/'),
(3, 'bodytop.gif', '/'),
(4, 'carrier.gif', '/'),
(5, 'ch.gif', '/'),
(6, 'daikin.gif', '/'),
(7, 'footer.gif', '/'),
(8, 'fujitsu.gif', '/'),
(9, 'general_climat.gif', '/'),
(10, 'gree.gif', '/'),
(11, 'header.gif', '/'),
(12, 'mitsubishi.gif', '/'),
(13, 'panasonic.gif', '/'),
(14, 'telo.gif', '/'),
(15, 'toshiba.gif', '/'),
(16, 'site1.gif', '/');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `parent_id` int(11) unsigned NOT NULL,
  `translit_title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `parent_id`, `translit_title`) VALUES
(1, 'category-1', 0, 'Категория 1'),
(2, 'Category-2', 0, 'Категория 2'),
(3, 'category-3', 0, 'категория 3'),
(4, 'category-4', 0, 'категория4'),
(5, 'category-1.1', 1, 'категория 1.1'),
(6, 'category-1.2', 1, 'категория 1.2');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `changed` enum('0','1') NOT NULL,
  `published` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `avatar`, `name`, `email`, `comment`, `created_at`, `changed`, `published`) VALUES
(1, 1, NULL, 'Voelkischer beobachter', 'weisse@ukr.net', 'Редчайшая фигня для коня и путина', '2015-12-18 14:43:06', '0', '1'),
(2, 1, NULL, 'хуйло обыкновеноу', 'weisse@ukr.net', 'согласен с колеггою', '2015-12-18 14:43:06', '0', '1'),
(3, 1, NULL, 'кремлевский троль', 'weisse@ukr.net', 'а мне нравится', '2015-12-18 14:45:13', '0', '1'),
(4, 1, NULL, 'ворошиловский стрелок', 'weisse@ukr.net', 'бум бум це я шляпа выд ', '2015-12-18 14:53:31', '0', '1'),
(10, 1, 'p1010001.jpg', 'test', 'weisse@ukr.net', 'asasasasasasas', '2015-12-24 11:08:56', '0', '1'),
(11, 1, 'p1010002.jpg', 'test2', 'weisse@ukr.net', 'Є, звичайно, й інші закони... Стверджують, що "наркотик вже не вставляє", і необхідно щось надпотужне, щоб напівбожевільний від реальної кризи глядач раптом "вштирився" і "закайфував". Мовляв, українська ейфорія вже розсіялася, а Сирія — далека і не настільки приваблива як "мрія про возз''єднання з Кримом та Україною". І можна не сумніватися, що наркотичну речовину, здатну затьмарити ефект попереднього, вже знайшли. Це — глобальна війна,\n— пише Саша Сотник.', '2015-12-24 11:19:09', '0', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `manufacturer`
--

CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `title`, `url`) VALUES
(1, 'siemens', '/'),
(2, 'sumsung', '/'),
(3, 'henkel', '/'),
(4, 'bauchemie', '/');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `products` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `message`, `products`, `time`) VALUES
(16, '', '', '', '', 'a:1:{i:0;a:4:{s:2:"id";i:1;s:6:"author";s:12:"Пушкин";s:5:"title";s:30:"Руслан и Людмила";s:6:"number";i:60;}}', '2015-12-30 14:48:01'),
(17, '3333', '', '33333333', '', 'a:1:{i:0;a:4:{s:2:"id";i:1;s:6:"author";s:12:"Пушкин";s:5:"title";s:30:"Руслан и Людмила";s:6:"number";i:60;}}', '2015-12-30 14:57:04'),
(18, 'rrrrrrr', '', '555555555', '', 'a:1:{i:0;a:4:{s:2:"id";i:1;s:6:"author";s:12:"Пушкин";s:5:"title";s:30:"Руслан и Людмила";s:6:"number";i:60;}}', '2015-12-30 15:00:22'),
(19, '4444444', '', '4444444444', '', 'a:1:{i:0;a:4:{s:2:"id";i:1;s:6:"author";s:12:"Пушкин";s:5:"title";s:30:"Руслан и Людмила";s:6:"number";i:20;}}', '2015-12-30 15:05:41'),
(20, '333', '', '333333333333', '', 'a:1:{i:0;a:4:{s:2:"id";i:1;s:6:"author";s:12:"Пушкин";s:5:"title";s:30:"Руслан и Людмила";s:6:"number";i:20;}}', '2015-12-30 15:07:00');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `body` text NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `cat_id` int(11) unsigned DEFAULT NULL,
  `manf_id` int(11) unsigned DEFAULT NULL,
  `images` text,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  KEY `manf_id` (`manf_id`)
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

-- --------------------------------------------------------

--
-- Структура таблицы `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `slider`
--

INSERT INTO `slider` (`id`, `image`, `url`) VALUES
(1, 'P1010013.jpg', '/'),
(2, 'P1010014.jpg', '/'),
(3, 'P1010026.jpg', '/'),
(4, 'P1010034.jpg', '/'),
(5, 'P1010046.jpg', '/');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`manf_id`) REFERENCES `manufacturer` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
