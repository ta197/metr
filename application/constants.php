<?php

const DEBUG = 1;
define( 'DIR_SEPARATOR ', '/' );
   define( 'ROOT', $_SERVER['DOCUMENT_ROOT']);
const PREFIX = ['admin', 'petrova']; // not main
const CONFIG = '../application/config/config.php';
const CACHE = '../tmp/cache';

/*inc для  views */

const NAV_ICON = '../application/views/main/nav_icon.inc';
const HEAD = '../application/views/main/head.inc';
const FOOTER = '../application/views/main/footer.inc';
const FIGURE = '../application/views/main/figure.inc';
const TITLE_H1 = '../application/views/main/title_h1.inc';
const ALPHABET_LETTERS = '../application/views/main/alphabet_letters.inc';
const CAT_MENU = '../application/views/main/cat_menu.inc';
const BRC = '../application/views/main/breadcrumb.inc';
const LIST_COMPANIES = '../application/views/main/list_companies.inc';
const LIST_GOODS = '../application/views/main/list_goods.inc';
const ERROR = '../application/views/main/error.inc';
const FORM_TITLE = '../application/views/main/form_title.inc';

const EMPTY_RESPONSE = '../application/views/main/search/empty_response.inc';
 const RESPONSE_BY_SEARCH_CASE = '../application/views/main/search/responseBySearch_case.inc';
const RESPONSE_BY_SEARCH_LIST_COMPANY = '../application/views/main/search/responseBySearch_list_company.inc';
const RESPONSE_BY_SEARCH_LIST_CATEGORY = '../application/views/main/search/responseBySearch_list_category.inc';
const RESPONSE_BY_SEARCH_LIST_GOODS = '../application/views/main/search/responseBySearch_list_goods.inc';
const RESPONSE_BY_SEARCH_LIST_PLACE = '../application/views/main/search/responseBySearch_list_place.inc';

const ADMIN_CAT_MENU = '../application/views/admin/admin_cat_menu.inc';
const ADMIN_FOOTER = '../application/views/admin/admin_footer.inc';
const ADMIN_NAV_ICON = '../application/views/admin/admin_nav_icon.inc';

const HEADER_REZUME = '../application/views/petrova/header_rezume.inc';
const FOOTER_REZUME = '../application/views/petrova/footer_rezume.inc';
const PETROVA_CONTACTS = '../application/views/petrova/petrova_contacts.inc';
const PETROVA_CERTIFICATES = '../application/views/petrova/petrova_certificates.inc';

const LAYOUT_DEFAULT_FILE = 'layout_default';
const DEFAULT_ERR = 'default_err';

/*Числовые константы */

const MIN_ANCOR = 3; //минимальное количество уникальных анкор-ссылок на странице, чтобы они показывались
const START_WORK_YEAR = 2016; //с какого года открытия считать компании новыми

?>