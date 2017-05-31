-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 02 2017 г., 14:09
-- Версия сервера: 5.5.35
-- Версия PHP: 5.3.10-1ubuntu3.26


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sa`
--

-- --------------------------------------------------------

--
-- Структура таблицы `approve`
--

CREATE TABLE IF NOT EXISTS `approve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org` int(11) DEFAULT NULL,
  `print` int(11) DEFAULT NULL,
  `equipment` int(11) DEFAULT NULL,
  `places` int(11) DEFAULT NULL,
  `nome` int(11) DEFAULT NULL,
  `group_nome` int(11) DEFAULT NULL,
  `vendor` int(11) DEFAULT NULL,
  `users` int(11) DEFAULT NULL,
  `requisites` int(11) DEFAULT NULL,
  `knt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED ;

-- --------------------------------------------------------

--
-- Структура таблицы `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersid` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL,
  `comment` longtext NOT NULL,
  `color` varchar(128) DEFAULT '#b8e77d',
  `textcolor` varchar(128) DEFAULT '#333',
  `remind` int(11) NOT NULL,
  `event_repeat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orgid` int(11) NOT NULL,
  `placesid` int(11) NOT NULL,
  `usersid` int(11) NOT NULL,
  `nomeid` int(11) NOT NULL,
  `buhname` varchar(255) NOT NULL,
  `datepost` date NOT NULL,
  `cost` decimal(9,2) NOT NULL,
  `currentcost` decimal(9,2) NOT NULL,
  `sernum` varchar(100) NOT NULL,
  `invnum` varchar(100) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `os` tinyint(1) NOT NULL,
  `mode` tinyint(1) NOT NULL,
  `bum` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'noimage.png',
  `repair` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `kntid` int(11) NOT NULL,
  `dtendgar` date NOT NULL,
  `util` int(3) NOT NULL DEFAULT '0',
  `sale` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `eq_param`
--

CREATE TABLE IF NOT EXISTS `eq_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eqid` int(11) NOT NULL,
  `pname` longtext NOT NULL,
  `param` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `files_contractor`
--

CREATE TABLE IF NOT EXISTS `files_contractor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcontract` int(11) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `userfreandlyfilename` varchar(255) NOT NULL,
  `file_ext` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `files_documents`
--

CREATE TABLE IF NOT EXISTS `files_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(200) NOT NULL,
  `userfreandlyfilename` varchar(255) NOT NULL,
  `file_ext` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `files_requisites`
--

CREATE TABLE IF NOT EXISTS `files_requisites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idrequisites` int(11) DEFAULT NULL,
  `filename` varchar(200) NOT NULL,
  `userfreandlyfilename` longtext NOT NULL,
  `dt` date NOT NULL,
  `file_ext` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `group_nome`
--

CREATE TABLE IF NOT EXISTS `group_nome` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `knt`
--

CREATE TABLE IF NOT EXISTS `knt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  `ERPCode` int(11) NOT NULL,
  `INN` varchar(20) NOT NULL,
  `KPP` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `license`
--

CREATE TABLE IF NOT EXISTS `license` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersid` int(11) DEFAULT NULL,
  `eqid` int(11) DEFAULT NULL,
  `system` int(11) DEFAULT NULL,
  `office` int(11) DEFAULT NULL,
  `organti` int(11) DEFAULT NULL,
  `antiname` int(11) DEFAULT NULL,
  `antivirus` date NOT NULL,
  `visio` tinyint(1) NOT NULL,
  `adobe` tinyint(1) NOT NULL,
  `lingvo` tinyint(1) NOT NULL,
  `winrar` tinyint(1) NOT NULL,
  `visual` tinyint(1) NOT NULL,
  `comment` longtext NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `move`
--

CREATE TABLE IF NOT EXISTS `move` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eqid` int(11) NOT NULL,
  `dt` datetime NOT NULL,
  `orgidfrom` int(11) NOT NULL,
  `orgidto` int(11) NOT NULL,
  `placesidfrom` int(11) NOT NULL,
  `placesidto` int(11) NOT NULL,
  `useridfrom` int(11) NOT NULL,
  `useridto` int(11) NOT NULL,
  `kntfrom` int(11) NOT NULL DEFAULT '3',
  `invoice` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_init_id` int(11) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `title` varchar(1024) DEFAULT NULL,
  `message` longtext,
  `hashname` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `nome`
--

CREATE TABLE IF NOT EXISTS `nome` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `vendorid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `noty`
--

CREATE TABLE IF NOT EXISTS `noty` (
  `id` int(11) NOT NULL,
  `noty_w` varchar(256) NOT NULL,
  `userid` varchar(512) NOT NULL DEFAULT '0',
  `user_read` varchar(512) NOT NULL DEFAULT '0',
  `dt` datetime NOT NULL,
  `message` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `org`
--

CREATE TABLE IF NOT EXISTS `org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `antivirus_col` varchar(10) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `perf`
--

CREATE TABLE IF NOT EXISTS `perf` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `param` varchar(512) NOT NULL DEFAULT '',
  `value` longtext NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

LOCK TABLES `perf` WRITE;
INSERT INTO `perf` (`id`, `param`, `value`)
VALUES
	(1, 'title_header', 'Учёт техники'),
	(2, 'hostname', 'http://localhost/'),
	(3, 'mail', 'your_name@company.local'),
	(4, 'name_of_firm', 'Учет техники'),
	(5, 'first_login', 'false'),
	(6, 'debug_mode', 'false'),
	(7, 'mail_active', 'false'),
	(8, 'mail_host', 'smtp.gmail.com'),
	(9, 'mail_port', '587'),
	(10, 'mail_auth', 'true'),
	(11, 'mail_auth_type', 'ssl'),
	(12, 'mail_username', 'your_login@gmail.com'),
	(13, 'mail_password', 'your_pass'),
	(14, 'mail_from', 'company'),
	(15, 'mail_debug', 'false'),
	(16, 'mail_type', 'sendmail'),
	(17, 'file_types', 'gif|jpe?g|png|doc|xls|rtf|pdf|zip|rar|bmp|docx|xlsx'),
	(18, 'file_size', '5000000'),
  (19, 'file_types_img', 'jpeg,jpg,png,bmp'),
  (20, 'permit_users_knt', ''),
  (21, 'permit_users_req', ''),
  (22, 'permit_users_cont', ''),
  (23, 'permit_users_documents', ''),
  (24, 'permit_users_news', ''),
  (25, 'permit_users_license', ''),
  (26, 'default_org', ''),
  (27, 'what_cartridge', 'null'),
  (28, 'what_print_test', 'null'),
  (29, 'what_license', 'null'),
  (30, 'home_text', 'приветствуем Вас на внутреннем сайте! Здесь вы сможете посмотреть какие ТМЦ за вами закреплены, что находиться в кабинте в котором вы работаете. Так же можно посмотреть контактную информацию пользователей, реквизиты организаций.'),
  (31, 'time_zone', 'Europe/Moscow');

UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Структура таблицы `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `comment` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `places_users`
--

CREATE TABLE IF NOT EXISTS `places_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placesid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `print`
--

CREATE TABLE IF NOT EXISTS `print` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomeid` int(11) NOT NULL,
  `orgid` int(11) NOT NULL,
  `placesid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `namek` varchar(255) NOT NULL,
  `coll` varchar(20) NOT NULL,
  `comment` longtext NOT NULL,
  `newk` tinyint(1) NOT NULL,
  `zapr` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `print_param`
--

CREATE TABLE IF NOT EXISTS `print_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dt` date NOT NULL,
  `printid` int(11) NOT NULL,
  `orgid` int(11) NOT NULL,
  `placesid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `coll2` varchar(20) NOT NULL,
  `comment` longtext NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `programming`
--

CREATE TABLE IF NOT EXISTS `programming` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `repair`
--

CREATE TABLE IF NOT EXISTS `repair` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dt` date NOT NULL,
  `kntid` int(11) NOT NULL,
  `eqid` int(11) NOT NULL,
  `cost` float NOT NULL,
  `comment` text NOT NULL,
  `dtend` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `requisites`
--

CREATE TABLE IF NOT EXISTS `requisites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `INN` varchar(20) NOT NULL,
  `KPP` varchar(20) NOT NULL,
  `ind` varchar(20) NOT NULL,
  `tel` longtext NOT NULL,
  `address` longtext NOT NULL,
  `active` tinyint(4) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shtr`
--

CREATE TABLE IF NOT EXISTS `shtr` (
  `id` int(11) NOT NULL DEFAULT '200',
  `eqid` int(11) NOT NULL,
  `orgid` int(3) NOT NULL,
  `shtr_id` int(7) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`,`orgid`,`shtr_id`),
  UNIQUE KEY `UNIQUE` (`eqid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `fio` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `priv` int(11) NOT NULL,
  `permit_menu` varchar(512) NOT NULL,
  `lastdt` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `on_off` tinyint(1) NOT NULL DEFAULT '1',
  `dostup` tinyint(1) NOT NULL DEFAULT '1',
  `lang` varchar(11) NOT NULL DEFAULT 'ru',
  `user_name` varchar(50) DEFAULT NULL,
  `us_kill` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

LOCK TABLES `users` WRITE;

INSERT INTO `users` (`id`, `fio`, `login`, `pass`, `priv`, `active`, `email`)
VALUES
	(1,'Main system account','system','1234','1','1','no-email@company.local');

UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Структура таблицы `users_profile`
--

CREATE TABLE IF NOT EXISTS `users_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersid` int(11) NOT NULL,
  `post` varchar(255) NOT NULL,
  `telephonenumber` varchar(20) NOT NULL,
  `homephone` varchar(20) NOT NULL,
  `birthday` varchar(10) NOT NULL,
  `emaildop` longtext NOT NULL,
  `jpegphoto` varchar(255) NOT NULL DEFAULT 'noavatar.png',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

LOCK TABLES `users_profile` WRITE;

INSERT INTO `users_profile` (`id`, `usersid`)
VALUES
	(1,1);

UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Структура таблицы `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `comment` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
