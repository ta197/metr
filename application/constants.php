<?php
const DEBUG = 0;
//define( ' DIR_SEPARATOR ', '/' );
   define( 'ROOT', $_SERVER['DOCUMENT_ROOT']);
const PREFIX = ['admin', 'petrova']; // not main
const CONFIG = ROOT.'/application/config/config.php';
const CACHE = ROOT.'/tmp/cache';
const BASE_TITLE = 'm2';

/*inc для  views */
const NAV_ICON = ROOT.'/application/views/main/nav_icon.inc';
const HEAD = ROOT.'/application/views/main/head.inc';
const FOOTER = ROOT.'/application/views/main/footer.inc';
const FIGURE = ROOT.'/application/views/main/figure.inc';
const TITLE_H1 = ROOT.'/application/views/main/title_h1.inc';
const NAV_LETTERS = ROOT.'/application/views/main/nav_letters.inc';
const CAT_MENU = ROOT.'/application/views/main/cat_menu.inc';
const BRC = ROOT.'/application/views/main/breadcrumb.inc';
const LIST_COMPANIES = ROOT.'/application/views/main/list_companies.inc';
const LIST_GOODS = ROOT.'/application/views/main/list_goods.inc';
const ERROR = ROOT.'/application/views/main/error.inc';
const FORM_TITLE = ROOT.'/application/views/main/form_title.inc';

/* основные layoutы */
const LAYOUT_DEFAULT_FILE = 'layout_default';
const DEFAULT_ERR = 'default_err';

/*Числовые константы */
const MIN_ANCOR = 3; //минимальное количество уникальных анкор-ссылок на странице, чтобы они показывались
const START_WORK_YEAR = 2016; //с какого года открытия считать компании новыми
const COUNT_ON_PAGE = 2; //количество записей на странице для пагинации
