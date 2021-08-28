-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 21 2018 г., 01:34
-- Версия сервера: 5.5.58-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `egg`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `cost` int(11) NOT NULL,
  `image` text CHARACTER SET utf8 NOT NULL,
  `item_image` text NOT NULL,
  `chance` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `cards`
--

INSERT INTO `cards` (`id`, `name`, `cost`, `image`, `item_image`, `chance`, `updated_at`, `created_at`) VALUES
(11, 'Яйца', 10, '/img/covers/11.jpg', '/img/items/11.png', 20, '2018-01-20 21:36:28', '0000-00-00 00:00:00'),
(12, 'Руны', 20, '/img/covers/12.jpg', '/img/items/12.png', 20, '2018-01-17 11:41:25', '0000-00-00 00:00:00'),
(13, 'Алхимия', 50, '/img/covers/13.jpg', '/img/items/13.png', 20, '2018-01-17 11:41:29', '0000-00-00 00:00:00'),
(14, 'Майя', 100, '/img/covers/14.jpg', '/img/items/14.png', 20, '2018-01-17 14:11:53', '0000-00-00 00:00:00'),
(15, 'Ограбление', 150, '/img/covers/15.jpg', '/img/items/15.png', 20, '2018-01-17 14:11:51', '0000-00-00 00:00:00'),
(16, 'Мафия', 300, '/img/covers/16.jpg', '/img/items/16.png', 20, '2018-01-17 11:41:40', '0000-00-00 00:00:00'),
(17, 'Фараон', 500, '/img/covers/17.jpg', '/img/items/17.png', 20, '2018-01-17 14:11:48', '0000-00-00 00:00:00'),
(18, 'Клад', 1000, '/img/covers/18.jpg', '/img/items/18.png', 20, '2018-01-17 14:11:46', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `drop_item` int(11) NOT NULL,
  `card` int(11) NOT NULL,
  `general_game` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card` int(11) NOT NULL,
  `image` text NOT NULL,
  `cost` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `card`, `image`, `cost`, `type`, `updated_at`, `created_at`) VALUES
(1, 11, '/img/coins/150/1.png', 1, 0, '2018-01-20 22:07:30', '0000-00-00 00:00:00'),
(2, 11, '/img/coins/150/3.png', 3, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(3, 11, '/img/coins/150/5.png', 5, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(4, 11, '/img/coins/150/7.png', 7, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(5, 11, '/img/coins/150/10.png', 10, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(6, 11, '/img/coins/150/15.png', 15, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(7, 11, '/img/coins/150/20.png', 20, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(8, 11, '/img/coins/150/30.png', 30, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(9, 11, '/img/coins/150/40.png', 40, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(10, 11, '/img/coins/150/50.png', 50, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(11, 11, '/img/coins/150/70.png', 70, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(12, 11, '/img/coins/150/100.png', 100, 0, '2018-01-17 11:56:50', '0000-00-00 00:00:00'),
(13, 12, '/img/coins/150/5.png', 5, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(14, 12, '/img/coins/150/7.png', 7, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(15, 12, '/img/coins/150/10.png', 10, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(16, 12, '/img/coins/150/15.png', 15, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(17, 12, '/img/coins/150/20.png', 20, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(18, 12, '/img/coins/150/30.png', 30, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(19, 12, '/img/coins/150/40.png', 40, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(20, 12, '/img/coins/150/50.png', 50, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(21, 12, '/img/coins/150/70.png', 70, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(22, 12, '/img/coins/150/100.png', 100, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(23, 12, '/img/coins/150/150.png', 150, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(24, 12, '/img/coins/150/250.png', 250, 0, '2018-01-17 12:07:32', '0000-00-00 00:00:00'),
(25, 13, '/img/coins/150/10.png', 10, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(26, 13, '/img/coins/150/20.png', 20, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(27, 13, '/img/coins/150/30.png', 30, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(28, 13, '/img/coins/150/40.png', 40, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(29, 13, '/img/coins/150/50.png', 50, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(30, 13, '/img/coins/150/70.png', 70, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(31, 13, '/img/coins/150/100.png', 100, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(32, 13, '/img/coins/150/150.png', 150, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(33, 13, '/img/coins/150/200.png', 200, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(34, 13, '/img/coins/150/300.png', 300, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(35, 13, '/img/coins/150/500.png', 500, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(36, 13, '/img/coins/150/1000.png', 1000, 0, '2018-01-17 12:11:57', '0000-00-00 00:00:00'),
(37, 14, '/img/coins/150/15.png', 15, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(38, 14, '/img/coins/150/20.png', 20, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(39, 14, '/img/coins/150/30.png', 30, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(40, 14, '/img/coins/150/50.png', 50, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(41, 14, '/img/coins/150/70.png', 70, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(42, 14, '/img/coins/150/100.png', 100, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(43, 14, '/img/coins/150/200.png', 200, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(44, 14, '/img/coins/150/300.png', 300, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(45, 14, '/img/coins/150/500.png', 500, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(46, 14, '/img/coins/150/700.png', 700, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(47, 14, '/img/coins/150/1000.png', 1000, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(48, 14, '/img/coins/150/5000.png', 5000, 0, '2018-01-17 12:15:30', '0000-00-00 00:00:00'),
(49, 15, '/img/coins/150/30.png', 30, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(50, 15, '/img/coins/150/40.png', 40, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(51, 15, '/img/coins/150/50.png', 50, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(52, 15, '/img/coins/150/70.png', 70, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(53, 15, '/img/coins/150/100.png', 100, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(54, 15, '/img/coins/150/150.png', 150, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(55, 15, '/img/coins/150/200.png', 200, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(56, 15, '/img/coins/150/400.png', 400, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(57, 15, '/img/coins/150/800.png', 800, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(58, 15, '/img/coins/150/1000.png', 1000, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(59, 15, '/img/coins/150/5000.png', 5000, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(60, 15, '/img/coins/150/15000.png', 15000, 0, '2018-01-17 12:19:22', '0000-00-00 00:00:00'),
(61, 16, '/img/coins/150/50.png', 50, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(62, 16, '/img/coins/150/80.png', 80, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(63, 16, '/img/coins/150/100.png', 100, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(64, 16, '/img/coins/150/150.png', 150, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(65, 16, '/img/coins/150/200.png', 200, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(66, 16, '/img/coins/150/250.png', 250, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(67, 16, '/img/coins/150/300.png', 300, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(68, 16, '/img/coins/150/700.png', 700, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(69, 16, '/img/coins/150/1000.png', 1000, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(70, 16, '/img/coins/150/5000.png', 5000, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(71, 16, '/img/coins/150/10000.png', 10000, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(72, 16, '/img/coins/150/50000.png', 50000, 0, '2018-01-17 12:23:28', '0000-00-00 00:00:00'),
(73, 17, '/img/coins/150/100.png', 100, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(74, 17, '/img/coins/150/150.png', 150, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(75, 17, '/img/coins/150/200.png', 200, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(76, 17, '/img/coins/150/250.png', 250, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(77, 17, '/img/coins/150/300.png', 300, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(78, 17, '/img/coins/150/400.png', 400, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(79, 17, '/img/coins/150/500.png', 500, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(80, 17, '/img/coins/150/1000.png', 1000, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(81, 17, '/img/coins/150/5000.png', 5000, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(82, 17, '/img/coins/150/10000.png', 10000, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(83, 17, '/img/coins/150/50000.png', 50000, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(84, 17, '/img/coins/150/250000.png', 250000, 0, '2018-01-17 12:30:02', '0000-00-00 00:00:00'),
(85, 18, '/img/coins/150/300.png', 300, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(86, 18, '/img/coins/150/400.png', 400, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(87, 18, '/img/coins/150/500.png', 500, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(88, 18, '/img/coins/150/600.png', 600, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(89, 18, '/img/coins/150/700.png', 700, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(90, 18, '/img/coins/150/800.png', 800, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(91, 18, '/img/coins/150/900.png', 900, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(92, 18, '/img/coins/150/1000.png', 1000, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(93, 18, '/img/coins/150/10000.png', 10000, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(94, 18, '/img/coins/150/50000.png', 50000, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(95, 18, '/img/coins/150/250000.png', 250000, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00'),
(96, 18, '/img/coins/150/1000000.png', 1000000, 0, '2018-01-17 12:36:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `operations`
--

CREATE TABLE IF NOT EXISTS `operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `ref_user` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `koshelek` varchar(11) DEFAULT NULL,
  `nomer` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text CHARACTER SET utf8 NOT NULL,
  `user_link` text CHARACTER SET utf8 NOT NULL,
  `user_avatar` text CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `photo` text CHARACTER SET utf8 NOT NULL,
  `opinion_link` text CHARACTER SET utf8 NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `min_dep` int(11) NOT NULL,
  `min_width` int(11) NOT NULL,
  `ref_percent` int(11) NOT NULL,
  `vk_group` text CHARACTER SET utf8 NOT NULL,
  `vk_token` text NOT NULL,
  `payment_type` int(11) NOT NULL,
  `fk_id` int(11) NOT NULL,
  `fk_secret1` varchar(16) NOT NULL,
  `fk_secret2` varchar(16) NOT NULL,
  `pt_shopid` int(11) NOT NULL,
  `pt_secret` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `min_dep`, `min_width`, `ref_percent`, `vk_group`, `vk_token`, `payment_type`, `fk_id`, `fk_secret1`, `fk_secret2`, `pt_shopid`, `pt_secret`, `updated_at`, `created_at`) VALUES
(1, 149, 100, 5, 'https://vk.com/cheap.scripts', '', 1, 0, '', '', 0, '', '2018-01-20 22:24:10', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `avatar` varchar(256) NOT NULL,
  `money` int(255) NOT NULL,
  `login` varchar(256) NOT NULL,
  `login2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` int(11) NOT NULL,
  `is_yt` int(11) NOT NULL,
  `ref_use` int(11) DEFAULT NULL,
  `profit` int(11) NOT NULL,
  `opened` int(11) NOT NULL,
  `ref_link` varchar(256) DEFAULT 'none',
  `deposit` int(11) NOT NULL,
  `bonus_money` int(11) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '2016-11-08 21:32:40',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
