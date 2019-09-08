-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 08 2019 г., 20:34
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `metr`
--

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
-- (См. Ниже фактическое представление)
--
CREATE TABLE `address` (
`company_id` int(11) unsigned
,`ul` text
,`id_ul` mediumtext
,`phone` mediumtext
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `address_business`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `address_business` (
`company_id` int(11) unsigned
,`ul` text
,`id_ul` mediumtext
,`phone` mediumtext
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
-- Структура таблицы `admin_icon`
--

CREATE TABLE `admin_icon` (
  `id` int(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon` varchar(256) NOT NULL,
  `visible` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admin_icon`
--

INSERT INTO `admin_icon` (`id`, `id_page`, `name`, `link`, `icon`, `visible`) VALUES
(1, 27, 'админ-панель', '/admin', 'nav__icon_logo', '1'),
(2, 29, 'категории', '/admin/category', 'nav__icon_routing', '1'),
(3, 30, 'компании', '/admin/company', 'nav__icon_lists', '1'),
(4, 31, 'каталог', '/admin/catalog', 'nav__icon_search', '1'),
(5, 44, 'пользователи', '/admin/user', 'nav__icon_lists', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `cats`
--

CREATE TABLE `cats` (
  `cat_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT 10,
  `lft` int(11) UNSIGNED NOT NULL,
  `rgt` int(11) UNSIGNED NOT NULL,
  `level` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `ref` int(11) NOT NULL DEFAULT 0,
  `activated` tinyint(1) NOT NULL DEFAULT 1,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `cats`
--

INSERT INTO `cats` (`cat_id`, `name`, `parent_id`, `lft`, `rgt`, `level`, `ref`, `activated`, `visible`) VALUES
(10, 'категории', 0, 1, 181, 0, 0, 1, 0),
(11, 'материалы для чистовой отделки', 10, 2, 17, 1, 0, 1, 1),
(12, 'обои', 11, 3, 4, 2, 32, 1, 1),
(13, 'плитка', 11, 5, 6, 2, 0, 1, 1),
(14, 'лаки, краска', 11, 7, 8, 2, 0, 1, 1),
(15, 'напольные покрытия', 11, 9, 16, 2, 0, 1, 1),
(16, 'ламинат', 15, 10, 11, 3, 0, 1, 1),
(17, 'паркетная доска', 15, 12, 13, 3, 0, 1, 1),
(18, 'линолеум', 15, 14, 15, 3, 0, 1, 1),
(19, 'материалы для черновой отделки', 10, 18, 33, 1, 0, 1, 1),
(20, 'листовые материалы', 19, 19, 24, 2, 0, 0, 1),
(21, 'гипсокартон', 20, 20, 21, 3, 0, 1, 1),
(22, 'ДВП, ДСП', 20, 22, 23, 3, 0, 1, 1),
(23, 'смеси, растворы', 19, 25, 32, 2, 0, 1, 1),
(24, 'штукатурка', 23, 26, 27, 3, 0, 1, 1),
(25, 'шпатлевка', 23, 28, 29, 3, 0, 1, 1),
(26, 'плиточный клей', 23, 30, 31, 3, 0, 1, 1),
(27, 'чистовые отделочные работы', 10, 34, 45, 1, 21, 0, 1),
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
(41, 'стройматериалы', 10, 62, 91, 1, 0, 0, 1),
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
(72, 'строительные работы', 10, 124, 139, 1, 0, 0, 1),
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
(85, 'лестницы', 10, 150, 155, 1, 0, 1, 0),
(86, 'деревянные', 85, 151, 152, 2, 0, 1, 0),
(87, 'стальные', 85, 153, 154, 2, 0, 1, 0),
(88, 'сантехника', 10, 156, 171, 1, 0, 1, 1),
(89, 'сантехработы', 88, 157, 158, 2, 0, 1, 1),
(90, 'продажа санфаянса', 88, 159, 160, 2, 0, 1, 1),
(91, 'продажа смесителей', 88, 161, 162, 2, 0, 1, 1),
(92, 'сантехарматура', 88, 163, 164, 2, 0, 1, 1),
(93, 'полотенцесушители', 88, 165, 166, 2, 0, 1, 0),
(94, 'счетчики воды', 88, 167, 168, 2, 0, 1, 1),
(95, 'восстановление ванн', 88, 169, 170, 2, 0, 1, 1),
(96, 'электромонтаж', 10, 172, 179, 1, 0, 0, 1),
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
  `quotes` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `company` varchar(255) NOT NULL,
  `name_type` enum('1','2','3','4','5','6','NULL') DEFAULT NULL COMMENT '1-shop; 2-legal; 3-shop, legal; 4-shop, legal, name_legal; 5- legal, name_legal; 6-legal, shop (после company)',
  `shop` varchar(100) DEFAULT NULL,
  `legal` int(3) DEFAULT NULL,
  `name_legal` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `about` text DEFAULT NULL,
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
(11, 0, 'Чесноков С.А.', '2', NULL, 1, '', NULL, '', '', '', NULL, NULL, 2017),
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
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
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
(13, 'маяки', 19, '2018-04-11 13:25:08', '', '', ''),
(18, 'жидкие обои', 11, '2019-07-14 09:00:20', '', '', ''),
(19, 'обои зеленые', 12, '2019-07-14 17:46:43', '', '', '');

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
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `view` varchar(255) NOT NULL,
  `table_name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id_menu`, `title`, `view`, `table_name`) VALUES
(1, 'метр иконочное', '/application/views/main/navicon.inc', 'nav_icon'),
(2, 'метр о проекте', '/application/views/main/footer.inc', 'nav_about'),
(4, 'админ иконочное', '', 'admin_icon'),
(5, 'резюме профессии', '', 'rezume_jobs'),
(6, 'резюме пример сайта', '', ''),
(7, 'резюме доп', 'rezume_extend', 'rezume_ext'),
(8, 'меню категории', '/application/views/main/cat_menu.inc', 'cats');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_in_pages`
--

CREATE TABLE `menu_in_pages` (
  `id_menu` int(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `num_sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `menu_in_pages`
--

INSERT INTO `menu_in_pages` (`id_menu`, `id_page`, `num_sort`) VALUES
(1, 2, 1),
(1, 3, 2),
(1, 4, 3),
(1, 5, 0),
(1, 6, 0),
(1, 7, 0),
(1, 8, 0),
(1, 9, 2),
(1, 11, 0),
(1, 12, 0),
(1, 15, 0),
(1, 19, 0),
(1, 20, 0),
(1, 21, 0),
(1, 23, 0),
(1, 24, 0),
(1, 25, 0),
(1, 26, 0),
(1, 33, 0),
(1, 34, 0),
(1, 35, 0),
(1, 36, 0),
(1, 37, 0),
(1, 38, 0),
(1, 39, 0),
(1, 40, 0),
(1, 41, 0),
(1, 42, 0),
(2, 1, 1),
(2, 2, 2),
(2, 3, 3),
(2, 4, 0),
(2, 5, 1),
(2, 6, 0),
(2, 7, 0),
(2, 8, 0),
(2, 11, 0),
(2, 12, 0),
(2, 15, 0),
(2, 19, 0),
(2, 20, 0),
(2, 21, 0),
(2, 23, 0),
(2, 24, 0),
(2, 25, 0),
(2, 26, 2),
(2, 33, 0),
(2, 34, 0),
(2, 35, 0),
(2, 36, 0),
(2, 37, 0),
(2, 38, 0),
(2, 39, 0),
(2, 40, 0),
(2, 41, 0),
(2, 42, 0),
(4, 13, 0),
(4, 16, 0),
(4, 27, 0),
(4, 28, 0),
(4, 29, 0),
(4, 30, 0),
(4, 31, 0),
(4, 32, 0),
(4, 44, 0),
(4, 45, 0),
(4, 46, 0),
(4, 47, 0),
(4, 56, 0),
(5, 48, 0),
(5, 49, 0),
(5, 50, 0),
(5, 51, 0),
(5, 52, 0),
(5, 53, 0),
(5, 54, 0),
(5, 55, 0),
(7, 48, 0),
(7, 49, 0),
(7, 50, 0),
(7, 51, 0),
(7, 52, 0),
(7, 53, 0),
(7, 54, 0),
(7, 55, 0),
(8, 5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `nav_about`
--

CREATE TABLE `nav_about` (
  `id` int(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `visible` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `nav_about`
--

INSERT INTO `nav_about` (`id`, `id_page`, `name`, `link`, `visible`) VALUES
(1, 2, 'о проекте\r\n', '/about', '1'),
(2, 3, 'контакты', '/about/contacts', '1'),
(3, 4, 'как с нами связаться\r\n', '/about/partners', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `nav_icon`
--

CREATE TABLE `nav_icon` (
  `id` tinyint(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `link` varchar(11) NOT NULL,
  `icon` varchar(256) NOT NULL,
  `visible` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `nav_icon`
--

INSERT INTO `nav_icon` (`id`, `id_page`, `name`, `link`, `icon`, `visible`) VALUES
(1, 1, 'главная', '/', 'nav__icon_logo', '1'),
(2, 5, 'категории', '/category', 'nav__icon_routing', '1'),
(3, 6, 'компании', '/company', 'nav__icon_lists', '1'),
(4, 7, 'поиск', '/search', 'nav__icon_search', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id_page` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `modul` varchar(255) NOT NULL DEFAULT 'main',
  `controller` varchar(255) NOT NULL DEFAULT 'index',
  `action` varchar(255) NOT NULL DEFAULT 'index',
  `params` varchar(255) NOT NULL,
  `url` varchar(256) NOT NULL,
  `full_cache_url` varchar(512) NOT NULL,
  `title` varchar(256) NOT NULL,
  `title_in_menu` varchar(256) NOT NULL,
  `header_title` varchar(256) NOT NULL,
  `subh1` varchar(255) NOT NULL,
  `keywords` varchar(256) NOT NULL,
  `description` varchar(256) NOT NULL,
  `visible` enum('0','1','2') NOT NULL DEFAULT '1',
  `children_sort` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id_page`, `id_parent`, `modul`, `controller`, `action`, `params`, `url`, `full_cache_url`, `title`, `title_in_menu`, `header_title`, `subh1`, `keywords`, `description`, `visible`, `children_sort`) VALUES
(1, 0, 'main', 'index', 'index_index', '', '/', '/', 'главная', 'Главная', '', '', 'Главная', 'Главная', '1', 0),
(2, 0, 'main', 'about', 'index', '', '/about', '/about', 'o проекте', 'О проекте', 'О проекте', '', 'Электронная версия справочника', 'Электронная версия справочника', '1', 0),
(3, 2, 'main', 'about', 'contacts', '', '/about/contacts', '/about/contacts', 'контакты', 'как с нами связаться', 'Контакты', '', '', 'как с нами связаться', '1', 0),
(4, 2, 'main', 'about', 'partners', '', '/about/partners', '/about/partners', 'рекламодателям', 'Рекламодателям', 'Рекламодателям', '', 'Рекламодателям', 'Рекламодателям', '1', 0),
(5, 0, 'main', 'category', 'index_category', '', '/category', '/category', 'категории', 'категории', 'Все категории', '', 'Все категории', 'Все категории', '1', 0),
(6, 0, 'main', 'company', 'index_company', '', '/company', '/company/index', 'компании', 'компании', 'Все компании', '', 'компании', 'компании', '1', 0),
(7, 0, 'main', 'search', 'index_search', '', '/search', '/search', 'поиск', 'поиск', 'Поиск по сайту', '', 'Поиск', 'Поиск', '1', 0),
(8, 5, 'main', 'category', 'section', 'cat, sub', '/category/section', '', '', '', '', '', '', '', '1', 0),
(10, 0, 'err', 'err', '404', '', 'err/err/404', '', 'ошибка 404', '', 'Ошибка 404', '', '', '', '1', 0),
(11, 0, 'err', 'err', '', '', 'err/err/err', '', 'Ошибка', '', 'Ошибка', '', '', '', '1', 0),
(12, 0, 'main', 'err', '404\r\n', '', 'main/err/404', '', 'ошибка 404', '', 'Ошибка 404', '', '', '', '1', 0),
(13, 0, 'admin', 'err', '404', '', 'admin/err/404', '', 'ошибка 404', '', 'Ошибка 404', '', '', '', '1', 0),
(14, 0, 'petrova', 'err', '404', '', 'petrova/err/404', '', 'ошибка 404', '', 'Oшибка 404', '', '', '', '1', 0),
(15, 0, 'main', 'err', '500', '', 'main/err/500', '', 'ошибка 500', '', 'Oшибка 500', '', '', '', '1', 0),
(16, 0, 'admin', 'err', '500', '', 'admin/err/500', '', 'ошибка 500', '', 'Ошибка 500', '', '', '', '1', 0),
(17, 0, 'petrova', 'err', '500', '', 'petrova/err/500', '', 'ошибка 500', '', 'Ошибка 500', '', '', '', '1', 0),
(19, 6, 'main', 'company', 'index', 'page', '/company/index', '/company/index', 'компании', 'компании', 'Все компании', '', '', '', '1', 0),
(20, 7, 'main', 'search', 'response', 'search', '/search/response', '/search/response/search/?search=магазин+Товары+для+дома', 'результат поиска', 'поиск', 'Результат поиска', '', '', '', '1', 0),
(21, 6, 'main', 'company', 'filters', 'search', '/company/filters', '/company', '', 'компании', '', '', '', '', '1', 0),
(23, 6, 'main', 'company', 'young', '', '/company/young', '/company/young', 'новые компании', 'новые компании', 'Новые организации', '', '', '', '1', 0),
(24, 6, 'main', 'company', 'archive', 'page', '/company/archive', '/company/archive', '', '', 'Организации, прекратившие работу', '', '', '', '1', 0),
(25, 6, 'main', 'company', 'alphabet', 'letter', '/company/alphabet', '', 'организации на букву', '', 'Организации на букву', '', '', '', '1', 0),
(26, 6, 'main', 'company', 'card', 'name', '/company/card', '', '', '', '', '', '', '', '1', 0),
(27, 0, 'admin', 'index', 'index_action', '', '/admin', '', 'админ-панель', '', 'Админ-панель', '', '', '', '1', 0),
(28, 44, 'admin', 'user', 'profile', '', '/admin/user/profile', '', 'личный кабинет', '', 'Личный кабинет', '', '', '', '1', 0),
(29, 0, 'admin', 'category', 'index', '', '/admin/category', '', 'категории', '', 'Категории', '', '', '', '1', 0),
(30, 0, 'admin', 'company', 'index', '', '/admin/company', '', 'oрганизации', '', 'Организации', '', '', '', '1', 0),
(31, 0, 'admin', 'catalog', 'index', '', '/admin/catalog', '', 'каталог', '', 'каталог', '', '', '', '1', 0),
(32, 44, 'admin', 'user', 'users', '', '/admin/user/users', '', 'список пользователей', 'список пользователей', 'список пользователей', '', '', '', '1', 0),
(33, 0, 'main', 'user', 'index_action', '', '/user', '', 'список пользователей', '', 'Список пользователей', '', '', '', '1', 0),
(34, 33, 'main', 'user', 'login', '', '/user/login', '', 'авторизация', '', 'Авторизация', '', '', '', '1', 0),
(35, 33, 'main', 'user', 'signup', '', '/user/signup', '', 'регистрация', '', 'Регистрация', '', '', '', '1', 0),
(36, 33, 'main', 'user', 'profile', '', '/user/profile', '', 'личный кабинет', '', 'Личный кабинет пользователя', '', '', '', '1', 0),
(37, 1, 'main', 'catalog', 'index', '', '/catalog', '', 'каталог', '', 'Каталог', '', '', '', '1', 0),
(38, 37, 'main', 'catalog', 'category', '', '/catalog/category', '', 'каталог', '', 'Каталог категории', '', '', '', '1', 0),
(39, 37, 'main', 'catalog', 'category-company', 'name,cat,g', '/catalog/company-category', '', '', '', '', '', '', '', '1', 0),
(40, 37, 'main', 'catalog', 'company', '', '/catalog/company', '', '', '', 'Каталог организации', '', '', '', '1', 0),
(41, 37, 'main', 'catalog', 'goods', '', '/catalog/goods', '', '', '', '', '', '', '', '1', 0),
(42, 37, 'main', 'catalog', 'place', '', '/catalog/place', '', '', '', 'Каталог организации', '(адрес:', '', '', '1', 0),
(43, 27, 'admin', 'user', 'login', '', '/admin/user/login', '', 'авторизация', '', 'Авторизация админа', '', '', '', '1', 0),
(44, 0, 'admin', 'user', 'index_index', '', '/admin/user', '', 'пользователи и админы', '', 'Список пользователей и админов', '', '', '', '1', 0),
(45, 44, 'admin', 'user', 'admins', '', '/admin/user/admins', '', 'список админов', '', 'Список администраторов', '', '', '', '1', 0),
(46, 29, 'admin', 'category', 'create', '', '/admin/category/create', '', 'новая категория', '', 'Добавить категорию', '', '', '', '1', 0),
(47, 30, 'admin', 'company', 'create', '', '/admin/company/create', '', 'добавить компанию', '', 'Добавить компанию', '', '', '', '1', 0),
(48, 55, 'petrova', 'rezume', 'index', '', '/petrova/rezume', '', 'Резюме Петровой Т. В.', '', 'Общая информация', '', '', '', '1', 0),
(49, 48, 'petrova', 'rezume', 'develop', '', '/petrova/rezume/develop', '', 'разработка', '', 'Веб-разработчик', '', '', '', '1', 0),
(50, 48, 'petrova', 'rezume', 'design', '', '/petrova/rezume/design', '', 'дизайн', '', 'Дизайнер, верстальщик (полиграфия)', '', '', '', '1', 0),
(51, 48, 'petrova', 'rezume', 'proofs', '', '/petrova/rezume/proofs', '', 'корректор', '', 'Корректор', '', '', '', '1', 0),
(52, 48, 'petrova', 'rezume', 'education', '', '/petrova/rezume/education', '', 'образование', '', 'Образование', '', '', '', '1', 0),
(53, 48, 'petrova', 'rezume', 'experience', '', '/petrova/rezume/experience', '', 'опыт работы', '', 'Опыт работы', '', '', '', '1', 0),
(54, 48, 'petrova', 'rezume', 'add', '', '/petrova/rezume/add', '', 'дополнительно', '', 'Дополнительная информация', '', '', '', '1', 0),
(55, 0, 'main', 'petrova', 'index', '', '/petrova', '', '', 'резюме', 'Общая информация', '', '', '', '1', 0),
(56, 30, 'admin', 'company', 'alphabet', 'letter', '/admin/company/alphabet', '', 'на букву', '', 'Организации на букву', '', '', '', '1', 0);

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
(121, 36, 98, NULL),
(122, 15, 11, NULL),
(123, 26, 11, NULL);

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
(22, 31, 4, 12000, 'шт.', '2018-05-08'),
(29, 26, 18, NULL, '', '2019-07-15'),
(30, 26, 19, NULL, '', '2018-04-07');

-- --------------------------------------------------------

--
-- Структура таблицы `rezume_ext`
--

CREATE TABLE `rezume_ext` (
  `id` int(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(256) NOT NULL,
  `visible` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rezume_ext`
--

INSERT INTO `rezume_ext` (`id`, `id_page`, `name`, `link`, `visible`) VALUES
(1, 52, 'образование', '/petrova/rezume/education', '1'),
(2, 53, 'опыт работы', '/petrova/rezume/experience', '1'),
(3, 54, 'дополнительно\r\n', '/petrova/rezume/add', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `rezume_jobs`
--

CREATE TABLE `rezume_jobs` (
  `id` int(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(256) NOT NULL,
  `visible` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rezume_jobs`
--

INSERT INTO `rezume_jobs` (`id`, `id_page`, `name`, `link`, `visible`) VALUES
(1, 49, 'разработка', '/petrova/rezume/develop', '1'),
(2, 50, 'дизайн', '/petrova/rezume/design', '1'),
(3, 51, 'корректура', '/petrova/rezume/proofs', '1');

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
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `login` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `name`, `email`, `role`) VALUES
(2, 'ta197', '$2y$10$lo/KraKgboiCG5fXMfK0VuKy.fiWm0AvtT0cGnX1gjpBznXMK31LK', 'Татьяна', 'ta197@mail.ru', 'user'),
(12, 'testadmin', '$2y$10$E0qQtbL0TrtNS50OHkqTeejIEfkAdUGwhMt1m3Uy.eLy/ncq/FDlG', 'Татьяна', 'admin197@mail.ru', 'admin'),
(13, 'pilot', '$2y$10$hAKnMEeiJSIg0cMKQLYJ1uqak93sy/lbCaTvrfNiykdgwKZb4TGz.', 'pil', 'pilot@mail.ru', 'user'),
(14, '+7 903 043-27-33', '$2y$10$2KKfovcarRETTtG6TPk4ueYsf2EFIm6uQM2Tk0Oa/ayimIvxQczJy', 'suum', 'g@mail.ru', 'user'),
(15, 'arzvedom', '$2y$10$i/9PSGI5QAi4aL0yi/ErCecslB3VbAwH6JGoj0C/ykj58WgAToJBW', 'arzvedom', 'arzvedom@gmail.ru', 'user');

-- --------------------------------------------------------

--
-- Структура для представления `address`
--
DROP TABLE IF EXISTS `address`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `address`  AS  select `p`.`company_id` AS `company_id`,`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) AS `ul`,concat_ws('^',`p`.`company_id`,convert(`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) using utf8mb4)) AS `id_ul`,substring_index(group_concat(`phones_to_string`(`p`.`tel`,`p`.`addtel`,`p`.`cell`,`p`.`add_cell`) separator ', '),', ',2) AS `phone` from (`places` `p` left join `centres` on(`p`.`centre` = `centres`.`id`)) group by concat_ws('^',`p`.`company_id`,convert(`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) using utf8mb4)) ;

-- --------------------------------------------------------

--
-- Структура для представления `address_business`
--
DROP TABLE IF EXISTS `address_business`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `address_business`  AS  select `p`.`company_id` AS `company_id`,`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) AS `ul`,concat_ws('^',`p`.`company_id`,convert(`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) using utf8mb4)) AS `id_ul`,substring_index(group_concat(`phones_to_string`(`p`.`tel`,`p`.`addtel`,`p`.`cell`,`p`.`add_cell`) separator ', '),', ',2) AS `phone`,`p`.`service` AS `service`,`p`.`manufacturing` AS `manufacturing`,`sh`.`name` AS `shop` from ((`places` `p` left join `centres` on(`p`.`centre` = `centres`.`id`)) left join `shop` `sh` on(`sh`.`id` = `p`.`shop`)) group by concat_ws('^',`p`.`company_id`,convert(`places_to_string`(`p`.`city`,`p`.`street`,`p`.`house`,`centres`.`address`,`centres`.`name_center`,`p`.`detail`,NULL,`p`.`unit_not`) using utf8mb4)) ;

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
-- Индексы таблицы `admin_icon`
--
ALTER TABLE `admin_icon`
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
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Индексы таблицы `menu_in_pages`
--
ALTER TABLE `menu_in_pages`
  ADD UNIQUE KEY `id_menu` (`id_menu`,`id_page`);

--
-- Индексы таблицы `nav_about`
--
ALTER TABLE `nav_about`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `nav_icon`
--
ALTER TABLE `nav_icon`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id_page`);

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
-- Индексы таблицы `rezume_ext`
--
ALTER TABLE `rezume_ext`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rezume_jobs`
--
ALTER TABLE `rezume_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT для таблицы `admin_icon`
--
ALTER TABLE `admin_icon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `cats`
--
ALTER TABLE `cats`
  MODIFY `cat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

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
  MODIFY `goods_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `legal`
--
ALTER TABLE `legal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `nav_about`
--
ALTER TABLE `nav_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `nav_icon`
--
ALTER TABLE `nav_icon`
  MODIFY `id` tinyint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT для таблицы `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `places_cats`
--
ALTER TABLE `places_cats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT для таблицы `places_goods`
--
ALTER TABLE `places_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `rezume_ext`
--
ALTER TABLE `rezume_ext`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `rezume_jobs`
--
ALTER TABLE `rezume_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
