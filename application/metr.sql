-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 26 2019 г., 20:18
-- Версия сервера: 5.7.16-log
-- Версия PHP: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `metr`
--

DELIMITER $$
--
-- Функции
--
CREATE  FUNCTION `cleaned_phone` (`p.cell` VARCHAR(15) CHARSET utf8) RETURNS VARCHAR(15) CHARSET utf8 NO SQL
BEGIN
Set @phone = `p.cell`;
RETURN
CASE
WHEN @phone THEN REPLACE(@phone, '-', '')
ELSE NULL
END;
END$$

CREATE FUNCTION `company_extend_to_string` (`c.name_type` ENUM('1','2','3','4','5','6','NULL') CHARSET utf8, `c.shop` VARCHAR(100) CHARSET utf8, `c.legal` ENUM('ИП','ООО','ОАО','ЗАО','ПАО','МУ') CHARSET utf8, `c.name_legal` VARCHAR(100) CHARSET utf8) RETURNS VARCHAR(255) CHARSET utf8 BEGIN
SET @name_type = `c.name_type`, @shop = `c.shop`, @legal = `c.legal`, @name_legal=`c.name_legal`;
RETURN
CASE @name_type
	WHEN 1 THEN CONCAT(', ', @shop)
    WHEN 2 THEN CONCAT(', ', @legal)
    WHEN 3 THEN CONCAT(', ', CONCAT_WS(', ', @shop, @legal))
	WHEN 4 THEN CONCAT(', ', CONCAT_WS('', CONCAT(@shop, ', '), @legal,' ', @name_legal)) 
    WHEN 5 THEN CONCAT(', ', CONCAT_WS(' ', @legal, @name_legal))
    WHEN 6 THEN CONCAT(', ', CONCAT_WS(', ', @legal, @shop))
    ELSE NULL
    END;
END$$

CREATE  FUNCTION `company_to_string` (`c.name_type` ENUM('1','2','3','4','5','6') CHARSET utf8, `c.shop` VARCHAR(100) CHARSET utf8, `legal.name` VARCHAR(50) CHARSET utf8, `c.name_legal` VARCHAR(100) CHARSET utf8, `c.quotes` INT(1) UNSIGNED, `c.company` VARCHAR(100) CHARSET utf8) RETURNS TEXT CHARSET utf8 NO SQL
BEGIN
SET @name_type = `c.name_type`, @shop = `c.shop`, @legal = `legal.name`, @name_legal=`c.name_legal`, @quotes=`c.quotes`, @company=`c.company`,
@qcompany = CONCAT('«', @company, '»');

RETURN
CASE @quotes 
	WHEN 1 THEN
	CASE @name_type 
		WHEN 1 THEN CONCAT_WS(', ', @qcompany, @shop)
    	WHEN 2 THEN CONCAT_WS(', ', @qcompany, @legal)
    	WHEN 3 THEN CONCAT_WS(', ', @qcompany, CONCAT_WS(', ', @shop, @legal))
		WHEN 4 THEN CONCAT_WS(', ', @qcompany, CONCAT_WS('', CONCAT(@shop, ', '), @legal,' ', @name_legal)) 
    	WHEN 5 THEN CONCAT_WS(', ', @qcompany, CONCAT_WS(' ', @legal, @name_legal))
    	WHEN 6 THEN CONCAT_WS(', ', @qcompany, CONCAT_WS(', ', @legal, @shop))
    ELSE @qcompany
	END
	WHEN 0 THEN
    CASE @name_type 
		WHEN 1 THEN CONCAT_WS(', ', @company, @shop)
    	WHEN 2 THEN CONCAT_WS(', ', @company, @legal)
    	WHEN 3 THEN CONCAT_WS(', ', @company, CONCAT_WS(', ', @shop, @legal))
		WHEN 4 THEN CONCAT_WS(', ', @company, CONCAT_WS('', CONCAT(@shop, ', '), @legal,' ', @name_legal)) 
    	WHEN 5 THEN CONCAT_WS(', ', @company, CONCAT_WS(' ', @legal, @name_legal))
    	WHEN 6 THEN CONCAT_WS(', ', @company, CONCAT_WS(', ', @legal, @shop))
    ELSE @company
	END
END;
END$$

CREATE  FUNCTION `phones_to_string` (`tel` VARCHAR(15) CHARSET utf8, `addtel` VARCHAR(15) CHARSET utf8, `cell` VARCHAR(15) CHARSET utf8, `add_cell` VARCHAR(15) CHARSET utf8) RETURNS TEXT CHARSET utf8 NO SQL
BEGIN
SET @tel = tel, @addtel = addtel, @cell = cell, @add_cell = add_cell;
RETURN
CASE
WHEN @tel OR @addtel OR @cell OR @add_cell THEN CONCAT(' | тел. ', CONCAT_WS(', ', phone_format(@tel), phone_format(@addtel), phone_format(@cell), @add_cell))
ELSE NULL
END;
END$$

CREATE  FUNCTION `phone_format` (`cell` VARCHAR(15) CHARSET utf8) RETURNS VARCHAR(15) CHARSET utf8 NO SQL
BEGIN
SET @t = cell;
RETURN
CASE
WHEN LENGTH(@t)=11 THEN 
	CONCAT_WS('-', LEFT(@t, 1), 
          	SUBSTRING(@t, 2, 3), 
          	SUBSTRING(@t, 5, 3), 
          	SUBSTRING(@t, 8, 2), 					
          	RIGHT(@t, 2))
WHEN LENGTH(@t)=5 THEN 
	CONCAT_WS('-', LEFT(@t, 1), 
          	SUBSTRING(@t, 2, 2), 					
          	RIGHT(@t, 2))
ELSE @t
END;
END$$

CREATE  FUNCTION `places_to_string` (`p.city` VARCHAR(50) CHARSET utf8, `p.street` VARCHAR(100) CHARSET utf8, `p.house` VARCHAR(10) CHARSET utf8, `centres.address` VARCHAR(100) CHARSET utf8, `centres.name_center` VARCHAR(30) CHARSET utf8, `p.detail` VARCHAR(255) CHARSET utf8, `p.unit_floor` VARCHAR(50) CHARSET utf8, `p.unit_not` VARCHAR(50) CHARSET utf8) RETURNS TEXT CHARSET utf8 BEGIN
SET @city = `p.city`, @street = `p.street`, @house = `p.house`, @centres_address =`centres.address`, @name_center = `centres.name_center`, @detail = `p.detail`, @unit_floor = `p.unit_floor`, @unit_not = `p.unit_not`;
RETURN
CONCAT_WS(', ', COALESCE(@centres_address, CONCAT_WS(', ', @city, @street, @house)), @name_center, @detail, CONCAT(@unit_floor, ' этаж'), @unit_not);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `activity`
--

CREATE TABLE `activity` (
  `id` int(10) NOT NULL,
  `parent` int(3) NOT NULL,
  `title` varchar(30) NOT NULL,
  `visible` int(2) NOT NULL,
  `position` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `activity`
--

INSERT INTO `activity` (`id`, `parent`, `title`, `visible`, `position`) VALUES
(1, 0, 'торговля', 1, 3),
(2, 0, 'услуги', 1, 2),
(3, 0, 'производство', 1, 1),
(4, 1, 'базы', 1, 0),
(5, 1, 'магазины', 1, 0),
(6, 1, 'на заказ', 1, 0),
(7, 1, 'интернет', 1, 0),
(8, 1, 'ТЦ', 1, 0),
(9, 1, 'ТД', 1, 0);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `address`
-- (See below for the actual view)
--
CREATE TABLE `address` (
`company_id` int(11) unsigned
,`ul` text
,`id_ul` mediumtext
,`phone` varchar(341)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `address_business`
-- (See below for the actual view)
--
CREATE TABLE `address_business` (
`company_id` int(11) unsigned
,`ul` text
,`id_ul` mediumtext
,`phone` varchar(341)
,`service` int(11)
,`manufacturing` int(11)
,`shop` varchar(255)
);

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(5) NOT NULL,
  `username` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arch_categories`
--

CREATE TABLE `arch_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent` int(10) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `activ` int(1) NOT NULL DEFAULT '1',
  `visible` int(1) NOT NULL DEFAULT '1',
  `sort` int(20) NOT NULL,
  `production` int(1) NOT NULL DEFAULT '0',
  `services` int(1) NOT NULL DEFAULT '0',
  `trade` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `arch_categories`
--

INSERT INTO `arch_categories` (`id`, `parent`, `title`, `activ`, `visible`, `sort`, `production`, `services`, `trade`) VALUES
(1, 0, 'по категориям', 0, 1, 1, 0, 0, 0),
(2, 0, 'по виду деятельности', 0, 1, 2, 0, 0, 0),
(3, 0, 'по группе товаров', 1, 1, 3, 0, 0, 0),
(4, 0, 'дополнительно', 1, 1, 4, 0, 0, 0),
(5, 4, 'архив', 1, 1, 5, 0, 0, 0),
(7, 2, 'производство', 1, 1, 1, 0, 0, 0),
(8, 2, 'торговля', 0, 1, 1, 0, 0, 0),
(9, 2, 'услуги', 1, 1, 1, 0, 0, 0),
(10, 8, 'магазины', 1, 1, 1, 0, 0, 0),
(11, 8, 'базы', 1, 1, 0, 0, 0, 0),
(12, 8, 'торговые центры', 1, 1, 1, 0, 0, 0),
(15, 51, 'Доставка стройматериалов', 1, 0, 0, 0, 0, 0),
(16, 40, 'сантехнические работы', 1, 1, 0, 0, 1, 0),
(17, 40, 'восстановление ванн', 1, 1, 5, 0, 1, 0),
(18, 20, 'поликарбонат', 1, 1, 0, 1, 0, 0),
(19, 30, 'производство профлиста', 1, 1, 0, 1, 0, 0),
(20, 1, 'производство стройматериалов', 1, 0, 1, 1, 0, 0),
(21, 20, 'пиломатериал', 1, 1, 0, 1, 0, 0),
(22, 20, 'гипсовые смеси', 1, 1, 0, 1, 0, 0),
(23, 1, 'двери', 0, 1, 110, 1, 1, 1),
(24, 23, 'производство дверей', 1, 1, 0, 1, 0, 0),
(25, 23, 'установка дверей', 1, 1, 0, 0, 1, 0),
(26, 23, 'продажа дверей', 1, 1, 0, 0, 0, 1),
(27, 1, 'фасад', 0, 1, 40, 1, 1, 1),
(28, 27, 'облицовочный камень', 1, 1, 0, 1, 0, 0),
(29, 27, 'виниловый сайдинг', 1, 1, 0, 0, 0, 1),
(30, 1, 'кровля', 0, 1, 40, 1, 1, 1),
(31, 1, 'электротовары', 1, 1, 90, 0, 0, 1),
(32, 31, 'продажа светильников', 1, 1, 100, 0, 0, 1),
(33, 31, 'продажа электрооборудования', 1, 1, 0, 0, 0, 1),
(34, 1, 'отделочные материалы', 1, 1, 60, 0, 0, 1),
(36, 34, 'обои', 1, 1, 0, 0, 0, 1),
(37, 1, 'окна', 1, 1, 100, 0, 1, 1),
(38, 1, 'продажа стройматериалов', 1, 1, 0, 0, 0, 1),
(39, 1, 'метизы, крепеж', 0, 1, 200, 0, 0, 1),
(40, 1, 'сантехника', 1, 1, 80, 0, 1, 1),
(41, 39, 'метизы', 1, 1, 0, 0, 0, 1),
(42, 40, 'продажа сантехарматуры', 1, 1, 0, 0, 0, 1),
(43, 38, 'поликарбонат', 1, 1, 0, 0, 0, 1),
(44, 42, 'продажа санфаянса', 1, 1, 0, 0, 0, 1),
(45, 30, 'продажа кровельныx материалов', 1, 1, 0, 0, 0, 1),
(46, 38, 'пиломатериал', 1, 1, 0, 0, 0, 1),
(47, 1, 'строительные работы', 0, 1, 10, 0, 1, 0),
(48, 27, 'фасадные работы', 1, 1, 5, 0, 1, 0),
(49, 30, 'кровельные работы', 1, 1, 2, 0, 1, 0),
(50, 47, 'общестроительные работы', 1, 1, 1, 0, 1, 0),
(51, 1, 'Транспортные услуги', 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `arch_space`
--

CREATE TABLE `arch_space` (
  `id` int(11) NOT NULL,
  `venue` int(5) NOT NULL,
  `parent` int(100) NOT NULL,
  `street` varchar(255) NOT NULL,
  `dom` varchar(255) NOT NULL,
  `mark_id` int(10) NOT NULL,
  `detail` varchar(100) NOT NULL,
  `tel` varchar(7) NOT NULL,
  `add_tel` varchar(10) DEFAULT NULL,
  `cell` varchar(15) NOT NULL,
  `add_cell` int(10) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `hours` varchar(100) NOT NULL,
  `person` varchar(30) NOT NULL,
  `section_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `arch_space`
--

INSERT INTO `arch_space` (`id`, `venue`, `parent`, `street`, `dom`, `mark_id`, `detail`, `tel`, `add_tel`, `cell`, `add_cell`, `email`, `city`, `hours`, `person`, `section_id`) VALUES
(2, 3, 0, 'Калинина', '2б', 0, 'напротив ТЦ Арсенал', '4-69-14', NULL, '', NULL, '', NULL, '', '', 10),
(3, 3, 0, 'Гостиный ряд', '33', 0, '', '9-03-82', NULL, '', NULL, '', NULL, '', '', 10),
(4, 3, 0, 'Ленина', '13', 0, '', '9-03-26', NULL, '', NULL, '', NULL, '', '', 10),
(5, 4, 0, 'Красный путь', '44', 0, '', '', NULL, '8-920-030-98-31', NULL, '', NULL, 'понедельник-суббота с 9.00 до 17.00, обед с 13.00 до 14.00, воскресенье - выходной', '', 6),
(7, 1, 0, 'Пландина', '12', 2, '1 этаж', '4-30-73', NULL, '', NULL, '', NULL, '', '', 12),
(8, 5, 0, 'Гостиный ряд', '30', 0, '', '9-08-20', NULL, '8-920-064-06-29', NULL, '', NULL, 'понедельник-суббота с 10.00 до 18.00, воскресенье - до 17.00', '', 6),
(9, 6, 0, '', '', 0, '', '', NULL, '8-920-003-34-66', NULL, '', NULL, '', '', 0),
(10, 7, 0, 'Ленина', '95', 0, '', '9-10-75', NULL, '', NULL, '', NULL, '', '', 0),
(11, 8, 0, '3-я Вокзальная', '8', 0, '', '6-05-18', NULL, '', NULL, '', NULL, '', '', 11),
(12, 9, 0, 'Пландина', '15', 0, '', '9-66-76', NULL, '', NULL, '', NULL, 'понедельник-суббота с 9.00 до 18.00, воскресенье - до 17.30', '', 10),
(13, 9, 12, 'Пландина', '15', 0, '1 этаж', '9-66-77', NULL, '', NULL, 'yyy@mail.ru', NULL, 'понедельник-суббота с 9.00 до 18.00, воскресенье - до 17.30', '', 10),
(14, 9, 12, 'Пландина', '15', 0, '2 этаж', '9-66-78', NULL, '', NULL, '', NULL, '', '', 10),
(15, 10, 0, 'Пландина', '12', 0, '', '7-67-07', NULL, '', NULL, '', NULL, '', '', 9),
(16, 2, 0, 'Пландина', '19', 0, '', '2-94-19', NULL, '', NULL, 'ttt@mail.ru', NULL, '', '', 10),
(19, 2, 16, 'Пландина', '19', 0, '1-ый этаж', '2-94-19', NULL, '', NULL, '', NULL, '', '', 10),
(20, 2, 16, 'Пландина', '19', 0, '2-й этаж', '', NULL, '', NULL, 'ttt@mail.ru', NULL, 'понедельник-суббота с 9.00 до 17.00, воскресенье - до 16.00', '', 10),
(21, 9, 0, 'Советская', '70', 0, '', '4-16-12', NULL, '', NULL, '', NULL, '', '', 10),
(22, 11, 0, 'Куликова', '', 0, '(возле ГСК-1)', '', NULL, '8-910-147-88-19', NULL, '', NULL, '', '', 1),
(24, 13, 0, '4-ая линия', '13а', 0, '', '5-14-18', NULL, '', NULL, '', 'р.п. Выездное', '', '', 1),
(25, 14, 0, 'Станционная', '32а', 0, '', '6-03-18', NULL, '8-910-121-11-55', NULL, '', NULL, '', '', 0),
(26, 15, 0, 'Ленина', '13', 0, '', '9-58-80', NULL, '', NULL, '', NULL, '', '', 10),
(27, 16, 0, 'Володарского', '83/2', 0, '', '77-8-06', '2-67-09', '', NULL, '', NULL, '', '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `arch_ul_categories`
--

CREATE TABLE `arch_ul_categories` (
  `id` int(11) NOT NULL,
  `ul_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `arch_ul_categories`
--

INSERT INTO `arch_ul_categories` (`id`, `ul_id`, `categories_id`) VALUES
(5, 2, 39),
(6, 2, 41),
(7, 2, 42),
(8, 3, 38),
(9, 3, 39),
(10, 3, 41),
(11, 3, 42),
(12, 3, 44),
(13, 3, 7),
(14, 4, 39),
(15, 4, 40),
(16, 4, 42),
(17, 5, 49),
(18, 5, 19),
(19, 5, 45),
(20, 7, 38),
(21, 7, 39),
(22, 7, 40),
(23, 7, 41),
(24, 7, 42),
(25, 7, 44),
(26, 8, 38),
(27, 8, 7),
(28, 8, 45),
(29, 8, 46),
(30, 10, 13),
(31, 10, 49),
(32, 10, 48),
(33, 9, 13),
(35, 11, 46),
(36, 11, 7),
(38, 11, 42),
(39, 13, 41),
(40, 13, 42),
(41, 13, 44),
(42, 1, 32),
(43, 1, 33),
(44, 13, 44),
(45, 15, 44),
(46, 14, 26),
(47, 15, 29),
(49, 19, 42),
(50, 19, 44),
(51, 20, 32),
(52, 20, 33),
(53, 21, 42),
(54, 14, 36),
(55, 22, 37),
(56, 24, 48),
(57, 26, 34),
(58, 26, 15),
(59, 25, 37),
(61, 26, 36),
(62, 26, 36),
(65, 27, 26),
(66, 27, 34),
(67, 27, 26),
(68, 27, 34),
(69, 27, 36);

-- --------------------------------------------------------

--
-- Структура таблицы `arch_venue`
--

CREATE TABLE `arch_venue` (
  `id` int(100) NOT NULL,
  `letter` varchar(2) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` int(100) DEFAULT NULL,
  `firm_1` varchar(100) DEFAULT NULL,
  `shop_0` varchar(100) DEFAULT NULL,
  `name_ooo` varchar(100) DEFAULT NULL,
  `name_ip` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `sole_trader` int(1) DEFAULT NULL,
  `vip` int(11) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL,
  `face` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `arch_venue`
--

INSERT INTO `arch_venue` (`id`, `letter`, `name`, `type`, `firm_1`, `shop_0`, `name_ooo`, `name_ip`, `site`, `sole_trader`, `vip`, `about`, `face`) VALUES
(1, 'а', '&laquo;Арсенал&raquo;', NULL, NULL, 'ТЦ', '', 'Хорьков', '', 1, 1, '', ''),
(2, 'т', '&laquo;Товары для дома&raquo;', 0, NULL, 'магазин', '', 'Рыбочкин', '', 0, 0, 'На рынке строительных материалов в Арзамасе 20 лет.', ''),
(3, 'х', '&laquo;Хозяин&raquo;', 0, 'ИП', 'сеть магазинов', '', 'Хорьков', '', 1, 1, '', ''),
(4, 'у', '&laquo;Усадьба&raquo;', 1, 'ООО', NULL, '', '', 'usadba-52.ru', 0, 0, '', ''),
(5, 'х', '&laquo;Хоздвор&raquo;', 0, 'ООО', 'магазин', '&laquo;Арабески&raquo;', '', '', 1, 0, '', ''),
(6, 'п', 'Пасько С.В.', 1, 'ИП', 'представитель', '', '', '', 1, 0, '', ''),
(7, 'р', 'Рябов Николай Васильевич', 1, 'ИП', NULL, '', 'Рябов', '', 1, 0, '', ''),
(8, 'б', 'База стройматериалов №1', 0, 'ИП', 'база строительных материалов', '', 'Налевайко', '', 0, 0, '', ''),
(9, 'н', '&laquo;Новосел&raquo;', NULL, NULL, 'магазин', '', '', 'novocol.ru', 0, 0, 'Сеть магазинов строительных и отделочных материалов. Работает с 2000 года. ', ''),
(10, 'ц', '&laquo;Центр кровли&raquo;', 1, 'ООО', NULL, '', '', '', NULL, 0, '', ''),
(11, 'ч', 'Чесноков С.А.', 1, 'ИП', NULL, '', '', '', 1, 0, '', ''),
(13, 'э', '&laquo;Эколайт&raquo;', 1, 'ООО', NULL, '', '', 'www.elarz.ru', NULL, 0, '', ''),
(14, 'к', '&laquo;Компания Фидес&raquo;', 3, 'ИП', NULL, '', 'Царьков В.М.', '', NULL, 0, '', ''),
(15, 'с', '&laquo;Свой дом&raquo;', 0, 'ООО', 'магазин', '', '', '', NULL, 1, '', 'svoi_dom'),
(16, 'д', '&laquo;Декор&raquo;', 0, NULL, 'магазин', '', '', '', NULL, 0, '', 'decor_face');

-- --------------------------------------------------------

--
-- Структура таблицы `cats`
--

CREATE TABLE `cats` (
  `cat_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT '10',
  `lft` int(11) UNSIGNED NOT NULL,
  `rgt` int(11) UNSIGNED NOT NULL,
  `level` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `ref` int(11) NOT NULL DEFAULT '0',
  `activated` tinyint(1) DEFAULT '1',
  `visible` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `cats`
--

INSERT INTO `cats` (`cat_id`, `name`, `parent_id`, `lft`, `rgt`, `level`, `ref`, `activated`, `visible`) VALUES
(10, 'категории', 0, 1, 266, 0, 0, 1, 0),
(11, 'материалы для чистовой отделки', 10, 2, 17, 1, 0, 1, 1),
(12, 'обои', 11, 3, 4, 2, 32, 1, 1),
(13, 'плитка', 11, 5, 6, 2, 0, 1, 1),
(14, 'лаки, краска', 11, 7, 8, 2, 0, 1, 1),
(15, 'напольные покрытия', 11, 9, 16, 2, 0, 1, 1),
(16, 'ламинат', 15, 10, 11, 3, 0, 1, 1),
(17, 'паркетная доска', 15, 12, 13, 3, 0, 1, 1),
(18, 'линолеум', 15, 14, 15, 3, 0, 1, 1),
(19, 'материалы для черновой отделки', 10, 18, 33, 1, 0, 1, 1),
(20, 'листовые материалы', 19, 19, 24, 2, 0, NULL, 1),
(21, 'гипсокартон', 20, 20, 21, 3, 0, 1, 1),
(22, 'ДВП, ДСП', 20, 22, 23, 3, 0, 1, 1),
(23, 'смеси, растворы', 19, 25, 32, 2, 0, 1, 1),
(24, 'штукатурка', 23, 26, 27, 3, 0, 1, 1),
(25, 'шпатлевка', 23, 28, 29, 3, 0, 1, 1),
(26, 'плиточный клей', 23, 30, 31, 3, 0, 1, 1),
(27, 'чистовые отделочные работы', 10, 34, 45, 1, 21, NULL, 1),
(28, 'натяжные потолки', 27, 35, 36, 2, 13, 1, 1),
(29, 'плиточные работы', 27, 37, 38, 2, 0, 1, 1),
(30, 'декоративная штукатурка', 27, 39, 40, 2, 0, 1, 1),
(31, 'поклейка обоев', 27, 41, 42, 2, 0, 1, 1),
(32, 'укладка напольных покрытий', 27, 43, 44, 2, 0, 1, 1),
(33, 'черновые отделочные работы', 10, 46, 61, 1, 0, 1, 1),
(34, 'работы с гипсокартоном', 33, 47, 48, 2, 0, 1, 1),
(35, 'штукатурные работы', 33, 49, 50, 2, 0, 1, 1),
(36, 'устройство полов', 33, 51, 56, 2, 0, 1, 1),
(37, 'наливной пол', 36, 52, 53, 3, 0, 1, 1),
(38, 'черновой пол', 36, 54, 55, 3, 0, 1, 1),
(39, 'перепланировка, проёмы', 33, 57, 58, 2, 0, 1, 1),
(40, 'комплексный ремонт', 33, 59, 60, 2, 0, 1, 1),
(41, 'стройматериалы', 10, 62, 91, 1, 0, NULL, 1),
(42, 'стеновые стройматериалы', 41, 63, 70, 2, 0, 1, 1),
(43, 'кирпич', 42, 64, 65, 3, 0, 1, 0),
(44, 'гипсовые блоки', 42, 66, 67, 3, 0, 1, 0),
(45, 'газосиликатные блоки', 42, 68, 69, 3, 0, 1, 0),
(46, 'бетон, раствор', 41, 71, 72, 2, 0, 1, 1),
(47, 'изделия из бетона', 41, 73, 74, 2, 0, 1, 1),
(48, 'насыпные стройматериалы', 41, 75, 82, 2, 0, 1, 1),
(49, 'песок', 48, 76, 77, 3, 0, 1, 0),
(50, 'щебень', 48, 78, 79, 3, 0, 1, 0),
(51, 'керамзит', 48, 80, 81, 3, 0, 1, 0),
(52, 'утеплители', 41, 83, 84, 2, 0, 1, 1),
(53, 'пиломатериалы', 41, 85, 86, 2, 0, 1, 1),
(54, 'металлопрокат', 41, 87, 88, 2, 0, 1, 1),
(55, 'сотовый поликарбонат', 41, 89, 90, 2, 0, 1, 1),
(56, 'кровля', 10, 92, 111, 1, 0, 1, 1),
(57, 'кровельные материалы', 56, 93, 108, 2, 0, 1, 1),
(58, 'профлист', 57, 94, 99, 3, 0, 1, 1),
(59, 'продажа профлиста', 58, 95, 96, 4, 0, 1, 0),
(60, 'производство профлиста', 58, 97, 98, 4, 0, 1, 0),
(61, 'металлочерепица', 57, 100, 101, 3, 0, 1, 1),
(62, 'доборные элементы', 57, 102, 103, 3, 0, 1, 1),
(63, 'водосточные системы', 57, 104, 105, 3, 0, 1, 1),
(64, 'мягкая кровля', 57, 106, 107, 3, 0, 1, 1),
(65, 'кровельные работы', 56, 109, 110, 2, 0, 1, 1),
(66, 'фасады', 10, 112, 123, 1, 0, 1, 1),
(67, 'фасадные материалы', 66, 113, 114, 2, 0, 1, 1),
(68, 'фасадные работы', 66, 115, 122, 2, 0, 1, 1),
(69, 'вентилируемые фасады', 68, 116, 117, 3, 0, 1, 1),
(70, 'утепление стен', 68, 118, 119, 3, 0, 1, 1),
(71, 'отделка сайдингом', 68, 120, 121, 3, 0, 1, 1),
(72, 'строительные работы', 10, 124, 139, 1, 0, NULL, 1),
(73, 'малоэтажное строительство', 72, 125, 126, 2, 0, 1, 1),
(74, 'общестроительные работы', 72, 127, 128, 2, 0, 1, 1),
(75, 'строительство дорог', 72, 129, 130, 2, 0, 1, 1),
(76, 'услуги стройтехники', 72, 131, 132, 2, 0, 1, 1),
(77, 'бурение', 72, 133, 134, 2, 0, 1, 1),
(78, 'проколы под дорогой', 72, 135, 136, 2, 0, 1, 1),
(79, 'бани, беседки', 72, 137, 138, 2, 0, 1, 1),
(80, 'металлоконструкции', 10, 140, 149, 1, 0, 1, 1),
(81, 'художественная ковка', 80, 141, 142, 2, 0, 1, 1),
(82, 'сварные конструкции', 80, 143, 144, 2, 0, 1, 1),
(83, 'порошковый окрас', 80, 145, 146, 2, 0, 1, 1),
(84, 'теплицы', 80, 147, 148, 2, 0, 1, 1),
(85, 'лестницы', 10, 150, 155, 1, 0, 1, NULL),
(86, 'деревянные', 85, 151, 152, 2, 0, 1, NULL),
(87, 'стальные', 85, 153, 154, 2, 0, 1, NULL),
(88, 'сантехника', 10, 156, 171, 1, 0, 1, 1),
(89, 'сантехработы', 88, 157, 158, 2, 0, 1, 1),
(90, 'продажа санфаянса', 88, 159, 160, 2, 0, 1, 1),
(91, 'продажа смесителей', 88, 161, 162, 2, 0, 1, 1),
(92, 'сантехарматура', 88, 163, 164, 2, 0, 1, 1),
(93, 'полотенцесушители', 88, 165, 166, 2, 0, 1, NULL),
(94, 'счетчики воды', 88, 167, 168, 2, 0, 1, 1),
(95, 'восстановление ванн', 88, 169, 170, 2, 0, 1, 1),
(96, 'электромонтаж', 10, 172, 179, 1, 0, NULL, 1),
(97, 'электромонтажные работы', 96, 173, 174, 2, 0, 1, 1),
(98, 'проекты электроснабжения', 96, 175, 176, 2, 0, 1, 1),
(99, 'услуги электрика', 96, 177, 178, 2, 0, 1, 1),
(100, 'метизы, крепеж', 10, 179, 180, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `centres`
--

CREATE TABLE `centres` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name_center` varchar(30) NOT NULL DEFAULT '&laquo;  &raquo;',
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `centres`
--

INSERT INTO `centres` (`id`, `name_center`, `address`) VALUES
(3, 'ТЦ «Калипсо»', 'ул. Пландина, 12б'),
(4, 'БЦ «Сити-парк»', 'ул. К.Маркса, 61'),
(5, 'БЦ «Диалог»', 'пр. Ленина, 208'),
(7, 'ТЦ «Арсенал»', 'ул. Пландина, 12'),
(8, 'ТЦ «Космос»', 'пр. Ленина, 166');

-- --------------------------------------------------------

--
-- Структура таблицы `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) UNSIGNED NOT NULL,
  `quotes` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `company` varchar(255) NOT NULL,
  `name_type` enum('1','2','3','4','5','6','NULL') DEFAULT NULL COMMENT '1-shop; 2-legal; 3-shop, legal; 4-shop, legal, name_legal; 5- legal, name_legal; 6-legal, shop (после company)',
  `shop` varchar(100) DEFAULT NULL,
  `legal` int(3) DEFAULT NULL,
  `name_legal` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `about` text,
  `face` varchar(100) DEFAULT NULL,
  `boss` varchar(50) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `archive` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `companies`
--

INSERT INTO `companies` (`company_id`, `quotes`, `company`, `name_type`, `shop`, `legal`, `name_legal`, `site`, `about`, `face`, `boss`, `rating`, `year`, `archive`) VALUES
(2, 1, 'Товары для дома', '1', 'магазин', 1, '', NULL, 'На рынке строительных материалов в Арзамасе 20 лет.', '', 'Рыбочкин', 9, NULL, NULL),
(3, 1, 'Хозяин', '1', 'сеть магазинов', 1, '', NULL, '', '', 'Хорьков', 20, 1999, NULL),
(4, 1, 'Усадьба', '2', NULL, 2, '', 'usadba-52.ru', '', '', '', NULL, 2008, NULL),
(5, 1, 'Хоздвор', '4', 'магазин', 2, '«Арабески»', NULL, '', '', '', NULL, NULL, 2018),
(6, 0, 'Пасько С.В.', '6', 'представитель', 1, '', NULL, '', '', '', NULL, 2016, NULL),
(7, 0, 'Рябов Николай Васильевич', '2', NULL, 1, 'Рябов', NULL, '', '', 'Рябов', NULL, NULL, NULL),
(8, 0, 'База стройматериалов №1', '4', 'база строительных материалов', 1, 'Налевайко', NULL, '', '', '', NULL, NULL, NULL),
(9, 1, 'Новосел', '1', 'магазин', NULL, '', 'novocol.ru', 'Сеть магазинов строительных и отделочных материалов. Работает с 2000 года. ', '', '', 12, 2000, NULL),
(10, 1, 'Центр кровли', '2', NULL, 2, '', NULL, '', '', '', NULL, 2016, NULL),
(11, 0, 'Чесноков С.А.', '2', NULL, 1, '', NULL, '', '', '', NULL, NULL, NULL),
(13, 1, 'Эколайт', '2', NULL, 2, '', 'elarz.ru', '', '', '', 11, NULL, NULL),
(14, 1, 'Компания Фидес', '5', NULL, 1, 'Царьков В.М.', NULL, '', '', '', 5, 2017, NULL),
(15, 1, 'Свой дом', '3', 'магазин', 2, '', NULL, '', 'svoi_dom', '', NULL, NULL, NULL),
(16, 1, 'Декор', '1', 'магазин', 2, '', NULL, '', 'decor_face', NULL, NULL, NULL, NULL),
(18, 0, 'Специализированный магазин видеонаблюдения', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2018, NULL),
(20, 1, 'Арсенал', '1', 'ТЦ', NULL, '', NULL, '', '', 'Хорьков', NULL, NULL, NULL),
(21, 1, '57 шурупов', '5', NULL, 1, 'Тукова Е.В.', NULL, NULL, NULL, NULL, 10, 2018, NULL),
(22, 1, 'STAVR', '5', NULL, 1, 'Борунова Е.А.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 1, 'Строитель-2', '2', '', 3, '', NULL, NULL, NULL, NULL, NULL, 2018, NULL),
(25, 1, 'Нижегородагропроект', '2', NULL, 4, 'Нижегородагропроект', NULL, NULL, NULL, NULL, NULL, 1988, NULL),
(26, 1, 'ОксиГазСервис', '2', NULL, 3, 'ОксиГазСервис', NULL, NULL, NULL, NULL, NULL, NULL, 2009),
(27, 1, 'СУ-7 СМТ', '2', NULL, 3, 'СУ-7 СМТ', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `goods_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `cat_id` int(11) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `short_description` varchar(1000) NOT NULL,
  `long_description` text NOT NULL,
  `link_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`goods_id`, `name`, `cat_id`, `date`, `short_description`, `long_description`, `link_photo`) VALUES
(1, 'ванна чугунная 120', 88, '2018-04-06 21:00:00', 'Производства г.Павлово.\r\nВысота 75 см.\r\nСъемные ножки в комплекте.Производства г.Павлово. Высота 75 см. Съемные ножки в комплекте.Производства г.Павлово. Высота 75 см. Съемные ножки в комплекте.Производства г.Павлово.\r\nВысота 75 см.Производства г.Павлово.\r\nВысота 75 см.Производства г.Павлово.\r\nВысота 75 см.Производства г.Павлово.\r\nВысота 75 см.Производства г.Павлово.\r\nВысота 75 см.\r\nСъемные ножки в комплекте.Производства г.Павлово. Высота 75 см. Съемные ножки в комплекте.Производства г.Павлово. Высота 75 см. Съемные ножки в комплекте.Производства г.Павлово.\r\nВысота 75 см.Производства г.Павлово.\r\nВысота 75 см.Производства г.Павлово.\r\nВысота 75 см.Производства г.Павлово.\r\nВысота 75 см.Производства г.Павлово.\r\nВысота 75 см.\r\nСъемные ножки в комплекте.Производства г.Павлово. Высота 75 см. Съемные ножки в комплекте.Производства г.Павлово. Высота 75 см. Съемные ножки в комплекте.Производства г.П', 'Долговечная и теплая.', ''),
(2, 'ванна акриловая', 88, '2018-04-06 21:00:00', '', '', ''),
(3, 'стойка душевая', 88, '2018-04-07 18:59:33', '', '', ''),
(4, 'навесной унитаз', 88, '2018-04-07 18:59:33', '', '', ''),
(5, 'люк для коммуникаций', 88, '2018-04-07 19:04:00', '', 'Скрывает коммуникации, устанавливается на любые виды покрытий (плитку, панели). Размеры: 20х30, 20х40, 40х60.Производства г.Павлово.\nВысота 75 см.\nСъемные ножки в комплекте.Производства г.Павлово. Высота 75 см. Съемные ножки в комплекте.', ''),
(6, 'смеситель (Китай)', 91, '2018-04-07 19:04:00', '', 'Пластиковый корпус', ''),
(7, 'ламинат', 16, '2018-04-09 16:36:22', '', '', ''),
(8, 'линолеум', 18, '2018-04-09 16:37:01', '', '', ''),
(9, 'обои Красненькие', 12, '2018-04-09 16:45:58', 'Виниловые, ширина 1м, пр-во Германии', 'В классическом стиле', ''),
(10, 'водоэмульсионная краска', 14, '2018-04-11 08:46:04', '', '', ''),
(11, 'клей ЕК200', 26, '2018-04-11 13:05:12', '', '', ''),
(12, 'бетон-контакт', 23, '2018-04-11 13:05:12', '', '', ''),
(13, 'маяки', 19, '2018-04-11 13:25:08', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `legal`
--

CREATE TABLE `legal` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `decoding` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `legal`
--

INSERT INTO `legal` (`id`, `name`, `decoding`) VALUES
(1, 'ИП', 'индивидуальный предприниматель'),
(2, 'ООО', 'общество с ограниченной ответственностью'),
(3, 'ОАО', NULL),
(4, 'ЗАО', NULL),
(5, 'ПАО', 'публичное акционерное общество'),
(6, 'МУ', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `places`
--

CREATE TABLE `places` (
  `place_id` int(11) UNSIGNED NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `house` varchar(10) DEFAULT NULL,
  `centre` tinyint(3) UNSIGNED DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `coords` varchar(50) NOT NULL,
  `unit_floor` varchar(50) DEFAULT NULL COMMENT 'обособленные торговые единицы по ассортименту в одном здании: этаж, офис',
  `unit_not` varchar(50) DEFAULT NULL COMMENT 'нет обособленных единиц в одном здании, этаж, офис',
  `tel` varchar(11) DEFAULT NULL,
  `addtel` varchar(15) DEFAULT NULL,
  `cell` varchar(15) DEFAULT NULL,
  `add_cell` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `work_mode` varchar(100) NOT NULL,
  `shop` int(11) DEFAULT NULL,
  `service` int(11) DEFAULT NULL,
  `manufacturing` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `places`
--

INSERT INTO `places` (`place_id`, `company_id`, `city`, `street`, `house`, `centre`, `detail`, `coords`, `unit_floor`, `unit_not`, `tel`, `addtel`, `cell`, `add_cell`, `email`, `work_mode`, `shop`, `service`, `manufacturing`) VALUES
(2, 3, NULL, 'ул. Калинина', '2б', NULL, 'напротив ТЦ «Арсенал»', '55.400778, 43.807926', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1, NULL, NULL),
(3, 3, NULL, 'ул. Гостиный ряд', '33', NULL, NULL, '55.383812, 43.814960', NULL, NULL, '90382', NULL, NULL, NULL, NULL, '', 1, NULL, NULL),
(4, 3, NULL, 'ул. Ленина', '13', NULL, NULL, '55.383904, 43.813783', NULL, NULL, '90326', NULL, NULL, NULL, NULL, '', 1, NULL, NULL),
(5, 4, NULL, 'ул. Красный путь', '44', NULL, NULL, '55.416785, 43.851934', NULL, NULL, NULL, NULL, '89200309831', '8-903-04-32-733', NULL, 'пн.-сб. с 9.00 до 17.00, обед с 13.00 до 14.00, вс. - выходной', 3, NULL, NULL),
(7, 20, NULL, 'ул. Пландина', '12', 7, NULL, '55.401549, 43.808537', '1', NULL, '43073', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(8, 5, NULL, 'ул. Гостиный ряд', '30', NULL, NULL, '55.384416, 43.814735', NULL, NULL, '90820', NULL, '89200640629', NULL, NULL, 'пн.-сб. с 10.00 до 18.00, вс. - до 17.00', 1, NULL, NULL),
(9, 6, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '89200033466', NULL, NULL, '', 1, NULL, NULL),
(10, 7, NULL, 'ул. Ленина', '95', NULL, NULL, '55.381076, 43.836232', NULL, NULL, '91075', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(11, 8, NULL, 'ул. 3-я Вокзальная', '8', NULL, NULL, '55.407193, 43.801314', NULL, NULL, '60518', NULL, NULL, NULL, NULL, '', 2, NULL, NULL),
(13, 9, NULL, 'ул. Пландина', '15', NULL, NULL, '55.405363, 43.814088', '1', NULL, '96677', NULL, '89030432733', '8-903-043-27-33', 'yyy@mail.ru', 'пн.-сб. с 9.00 до 18.00, вс. - до 17.30', 1, NULL, NULL),
(14, 9, NULL, 'ул. Пландина', '15', NULL, NULL, '55.405363, 43.814088', '2', NULL, '96678', NULL, NULL, '8-903-04-32-733', NULL, '', 1, NULL, NULL),
(15, 10, NULL, 'ул. Пландина', '12', 7, NULL, '55.401549, 43.808537', NULL, NULL, '76707', NULL, NULL, NULL, NULL, '', 1, NULL, NULL),
(16, 2, NULL, 'ул. Пландина', '19', NULL, NULL, '55.404984, 43.813226', 'цокольный', NULL, '29419', NULL, '89030432733', NULL, 'ttt@mail.ru', '', 1, NULL, NULL),
(19, 2, NULL, 'ул. Пландина', '19', NULL, NULL, '55.404984, 43.813226', '1', NULL, '29419', NULL, NULL, NULL, NULL, '', 1, NULL, NULL),
(20, 2, NULL, 'ул. Пландина', '19', NULL, NULL, '55.404984, 43.813226', '2', NULL, NULL, NULL, NULL, NULL, 'ttt@mail.ru', 'пн.-сб. с 9.00 до 17.00, вс. - до 16.00', 1, NULL, NULL),
(21, 9, NULL, 'ул. Советская', '70', NULL, NULL, '55.398998, 43.810405', NULL, NULL, '41612', NULL, NULL, NULL, NULL, '', 1, NULL, NULL),
(22, 11, NULL, 'ул. Куликова', NULL, NULL, 'возле ГСК-1', '', NULL, NULL, NULL, NULL, '89101478819', NULL, NULL, '', NULL, 1, 1),
(24, 13, 'р.п. Выездное', 'ул. 4-ая линия', '13а', NULL, NULL, '55.379987, 43.794595', NULL, NULL, '51418', NULL, NULL, NULL, NULL, '', NULL, 1, 1),
(25, 14, NULL, 'ул. Станционная', '32а', NULL, NULL, '55.405506, 43.797326', NULL, NULL, '60318', NULL, '89101211155', NULL, NULL, '', NULL, NULL, NULL),
(26, 15, NULL, 'ул. Ленина', '13', NULL, NULL, '55.383904, 43.813783', NULL, NULL, '95880', NULL, NULL, NULL, NULL, '', 1, NULL, NULL),
(28, 18, NULL, NULL, NULL, 4, NULL, '', NULL, 'цокольный этаж', NULL, NULL, '89200249595', NULL, NULL, '', NULL, NULL, NULL),
(29, 2, NULL, 'пр. Ленина', '166', 8, NULL, '55.397225, 43.830950', 'цокольный', NULL, NULL, NULL, '89503624150', NULL, NULL, '', 1, NULL, NULL),
(30, 16, NULL, 'ул. Володарского', '83/2', NULL, NULL, '55.371158, 43.824760', NULL, NULL, '77806', NULL, '89101078754', NULL, NULL, '', 1, NULL, NULL),
(31, 9, NULL, 'ул. Пландина', '15', NULL, NULL, '55.405363, 43.814088', 'цокольный', NULL, NULL, NULL, NULL, NULL, NULL, '', 1, NULL, NULL),
(32, 21, NULL, 'Володарского', '79', NULL, NULL, '55.373905, 43.822227', NULL, NULL, '91692', NULL, '89159568344', NULL, NULL, '', 1, NULL, NULL),
(33, 22, NULL, 'Калинина', '2в', NULL, 'магазин «ТМК»', '55.400604, 43.808456', NULL, 'цокольный этаж', '76561', NULL, '89871124041', NULL, NULL, '', NULL, NULL, 1),
(35, 24, NULL, 'Севастопольская', '29', NULL, NULL, '55.397858, 43.846383', NULL, NULL, '70764', NULL, NULL, NULL, NULL, '', NULL, 1, NULL),
(36, 25, NULL, 'ул. К.Маркса', '1', NULL, NULL, '55.388118, 43.816262', NULL, 'офис 214', '94301', '94189', NULL, NULL, NULL, '', NULL, NULL, NULL),
(37, 26, NULL, 'ул. Ленина', '110', NULL, NULL, '55.379675, 43.840274', NULL, NULL, NULL, NULL, '89519060208', NULL, NULL, '', NULL, NULL, NULL),
(38, 27, NULL, 'ул. Жуковского', '10', NULL, NULL, '55.406574, 43.819065', NULL, NULL, '73246', '70354', NULL, NULL, NULL, '', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `places_cats`
--

CREATE TABLE `places_cats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` int(11) UNSIGNED NOT NULL,
  `cat_id` int(11) UNSIGNED NOT NULL,
  `disabled` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `places_cats`
--

INSERT INTO `places_cats` (`id`, `place_id`, `cat_id`, `disabled`) VALUES
(1, 2, 14, NULL),
(3, 2, 26, NULL),
(4, 2, 52, NULL),
(9, 2, 23, NULL),
(10, 2, 24, NULL),
(11, 2, 25, NULL),
(13, 2, 92, NULL),
(14, 2, 93, NULL),
(16, 3, 14, NULL),
(33, 3, 26, NULL),
(34, 3, 23, NULL),
(35, 3, 24, NULL),
(36, 3, 25, NULL),
(37, 3, 52, NULL),
(38, 3, 91, NULL),
(39, 3, 92, NULL),
(40, 4, 14, NULL),
(41, 4, 23, NULL),
(55, 4, 94, NULL),
(56, 4, 24, NULL),
(57, 4, 25, NULL),
(58, 4, 26, NULL),
(59, 4, 52, NULL),
(60, 4, 91, NULL),
(61, 4, 92, NULL),
(62, 5, 57, NULL),
(63, 5, 58, NULL),
(64, 5, 59, NULL),
(65, 5, 60, NULL),
(66, 5, 61, NULL),
(67, 5, 62, NULL),
(68, 5, 63, NULL),
(69, 5, 65, NULL),
(70, 7, 11, NULL),
(71, 7, 14, NULL),
(72, 7, 88, NULL),
(73, 7, 90, NULL),
(74, 7, 91, NULL),
(75, 7, 92, NULL),
(76, 7, 93, NULL),
(91, 8, 14, NULL),
(92, 8, 23, NULL),
(93, 8, 24, NULL),
(94, 8, 25, NULL),
(95, 8, 26, NULL),
(96, 8, 92, NULL),
(97, 16, 91, NULL),
(98, 16, 92, NULL),
(99, 16, 93, NULL),
(100, 31, 88, NULL),
(101, 13, 16, NULL),
(102, 13, 18, NULL),
(103, 14, 12, NULL),
(104, 21, 12, NULL),
(105, 2, 91, NULL),
(106, 2, 88, NULL),
(108, 2, 10, NULL),
(111, 4, 19, NULL),
(112, 3, 19, NULL),
(113, 26, 12, NULL),
(114, 32, 100, NULL),
(118, 33, 83, NULL),
(119, 33, 81, NULL),
(120, 35, 73, NULL),
(121, 36, 98, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `places_goods`
--

CREATE TABLE `places_goods` (
  `id` int(11) NOT NULL,
  `place_id` int(11) UNSIGNED NOT NULL,
  `goods_id` int(11) UNSIGNED NOT NULL,
  `price` int(11) UNSIGNED DEFAULT NULL,
  `unit` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `places_goods`
--

INSERT INTO `places_goods` (`id`, `place_id`, `goods_id`, `price`, `unit`, `date`) VALUES
(1, 2, 5, NULL, '', '0000-00-00'),
(2, 2, 6, 780, 'за штуку', '2018-04-01'),
(3, 2, 3, 1800, '', '2018-04-09'),
(5, 31, 2, NULL, '', '0000-00-00'),
(6, 13, 7, NULL, '', '0000-00-00'),
(7, 13, 8, NULL, '', '0000-00-00'),
(8, 14, 9, 2000, 'за рулон', '2018-04-05'),
(9, 21, 9, NULL, '', '0000-00-00'),
(10, 8, 10, 4444, '', '0000-00-00'),
(11, 2, 10, NULL, '', '0000-00-00'),
(14, 4, 11, NULL, '', '0000-00-00'),
(15, 4, 12, NULL, '', '0000-00-00'),
(16, 3, 13, NULL, '', '0000-00-00'),
(17, 26, 9, 1500, 'за рулон', '2018-04-10'),
(18, 31, 1, 10000, '', '2018-04-07'),
(19, 7, 1, 11500, 'за штуку', '2018-04-04'),
(21, 16, 6, 5600, 'за штуку', '2018-04-01'),
(22, 31, 4, 12000, 'шт.', '2018-05-08');

-- --------------------------------------------------------

--
-- Структура таблицы `shop`
--

CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `visible` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `shop`
--

INSERT INTO `shop` (`id`, `name`, `visible`, `position`) VALUES
(1, 'магазин', 1, 1),
(2, 'база', 1, 2),
(3, 'на заказ', 1, 3),
(4, 'пункт выдачи', 1, 4),
(5, 'офис продаж', 1, 5);

-- --------------------------------------------------------

--
-- Структура для представления `address`
--
DROP TABLE IF EXISTS `address`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `address`  AS  select `p`.`company_id` AS `company_id`,`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) AS `ul`,concat_ws('^',`p`.`company_id`,convert(`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) using utf8mb4)) AS `id_ul`,substring_index(group_concat(`phones_to_string`(`p`.`tel`,`p`.`addtel`,`p`.`cell`,`p`.`add_cell`) separator ', '),', ',2) AS `phone` from (`places` `p` left join `centres` on((`p`.`centre` = `centres`.`id`))) group by `id_ul` ;

-- --------------------------------------------------------

--
-- Структура для представления `address_business`
--
DROP TABLE IF EXISTS `address_business`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `address_business`  AS  select `p`.`company_id` AS `company_id`,`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) AS `ul`,concat_ws('^',`p`.`company_id`,convert(`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) using utf8mb4)) AS `id_ul`,substring_index(group_concat(`phones_to_string`(`p`.`tel`,`p`.`addtel`,`p`.`cell`,`p`.`add_cell`) separator ', '),', ',2) AS `phone`,`p`.`service` AS `service`,`p`.`manufacturing` AS `manufacturing`,`sh`.`name` AS `shop` from ((`places` `p` left join `centres` on((`p`.`centre` = `centres`.`id`))) left join `shop` `sh` on((`sh`.`id` = `p`.`shop`))) group by `id_ul` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `arch_categories`
--
ALTER TABLE `arch_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `arch_space`
--
ALTER TABLE `arch_space`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `trade_id` (`section_id`),
  ADD KEY `id_2` (`id`);

--
-- Индексы таблицы `arch_ul_categories`
--
ALTER TABLE `arch_ul_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `arch_venue`
--
ALTER TABLE `arch_venue`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `idx_keys` (`lft`,`rgt`);

--
-- Индексы таблицы `centres`
--
ALTER TABLE `centres`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`goods_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Индексы таблицы `legal`
--
ALTER TABLE `legal`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`),
  ADD KEY `centre` (`centre`),
  ADD KEY `places_ibfk_1` (`company_id`);

--
-- Индексы таблицы `places_cats`
--
ALTER TABLE `places_cats`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `place_cat_unique` (`place_id`,`cat_id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Индексы таблицы `places_goods`
--
ALTER TABLE `places_goods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `place_id` (`place_id`,`goods_id`);

--
-- Индексы таблицы `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `arch_categories`
--
ALTER TABLE `arch_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT для таблицы `arch_space`
--
ALTER TABLE `arch_space`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT для таблицы `arch_ul_categories`
--
ALTER TABLE `arch_ul_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT для таблицы `arch_venue`
--
ALTER TABLE `arch_venue`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `cats`
--
ALTER TABLE `cats`
  MODIFY `cat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT для таблицы `centres`
--
ALTER TABLE `centres`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `goods_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `legal`
--
ALTER TABLE `legal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT для таблицы `places_cats`
--
ALTER TABLE `places_cats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
--
-- AUTO_INCREMENT для таблицы `places_goods`
--
ALTER TABLE `places_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT для таблицы `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `goods`
--
ALTER TABLE `goods`
  ADD CONSTRAINT `goods_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `cats` (`cat_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `places_ibfk_2` FOREIGN KEY (`centre`) REFERENCES `centres` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `places_cats`
--
ALTER TABLE `places_cats`
  ADD CONSTRAINT `places_cats_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `places_cats_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `cats` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
