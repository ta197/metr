<?php

const DEBUG = 1;
const PREFIX = ['admin', 'petrova']; // not main
const CONFIG = 'config/config.php';
const CACHE = 'tmp/cache';

/*inc для  views */

const NAV_ICON = 'application/views/main/nav_icon.inc';
const HEAD = 'application/views/main/head.inc';
const FOOTER = 'application/views/main/footer.inc';
const FIGURE = 'application/views/main/figure.inc';
const TITLE_H1 = 'application/views/main/title_h1.inc';
const ALPHABET_LETTERS = 'application/views/main/alphabet_letters.inc';
const CAT_MENU = 'application/views/main/cat_menu.inc';
const BRC = 'application/views/main/breadcrumb.inc';
const LIST_COMPANIES = 'application/views/main/list_companies.inc';
const LIST_GOODS = 'application/views/main/list_goods.inc';
const ERROR = 'application/views/main/error.inc';

const EMPTY_RESPONSE = 'application/views/main/search/empty_response.inc';
 const RESPONSE_BY_SEARCH_CASE = 'application/views/main/search/responseBySearch_case.inc';
const RESPONSE_BY_SEARCH_LIST_COMPANY = 'application/views/main/search/responseBySearch_list_company.inc';
const RESPONSE_BY_SEARCH_LIST_CATEGORY = 'application/views/main/search/responseBySearch_list_category.inc';
const RESPONSE_BY_SEARCH_LIST_GOODS = 'application/views/main/search/responseBySearch_list_goods.inc';
const RESPONSE_BY_SEARCH_LIST_PLACE = 'application/views/main/search/responseBySearch_list_place.inc';

const ADMIN_CAT_MENU = 'admin_cat_menu.inc';
const ADMIN_FOOTER = 'admin_footer.inc';
const ADMIN_NAV_ICON = 'admin_nav_icon.inc';

const HEADER_REZUME = 'header_rezume.inc';
const FOOTER_REZUME = 'footer_rezume.inc';
const PETROVA_CONTACTS = 'petrova_contacts.inc';
//const PETROVA_MENU_EXAMPLE = 'menu_example.inc';
const PETROVA_CERTIFICATES = 'petrova_certificates.inc';

const LAYOUT_DEFAULT_FILE = 'layout_default';
const DEFAULT_ERR = 'default_err';

/*Числовые константы */

const MIN_ANCOR = 3; //минимальное количество уникальных анкор-ссылок на странице, чтобы они показывались
const START_WORK_YEAR = 2016; //с какого года открытия считать компании новыми

?>