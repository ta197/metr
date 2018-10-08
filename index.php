<?php
error_reporting(E_ALL);

//error_reporting(-1);
/* Пути по-умолчанию для поиска файлов */
set_include_path(get_include_path()
					.PATH_SEPARATOR.'application/controllers'
					.PATH_SEPARATOR.'application/models'
                    .PATH_SEPARATOR.'application/base'
					.PATH_SEPARATOR.'application/views');

/*Имена файлов: views */
const DEFAULT_FILE = 'default.php';
const DEFAULT_CATEGORY_FILE = 'default_category.php';
const DEFAULT_COMPANY_FILE = 'default_company.php';
const DEFAULT_SEARCH_FILE = 'default_search.php';
const DEFAULT_ADMIN_FILE = 'default_admin.php';
const DEFAULT_ABOUT_FILE = 'default_about.php';


const NAV_ICON = 'nav_icon.inc';
const HEAD = 'head.inc';
const FOOTER = 'footer.inc.php';
const FIGURE = 'figure.inc';
const TITLE_H1 = 'title_h1.inc';
const CAT_MENU = 'cat_menu.inc';
const BRC = 'breadcrumb.inc';
const LIST_COMPANIES = 'list_companies.inc';
const LIST_GOODS = 'list_goods.inc';

const CATEGORY_VIEW_FILE = 'category_view.php';
const COMPANY_CARD_VIEW_FILE = 'company_card_view.php';
const GOODS_VIEW_FILE = 'goods_view.php';
const GOODS_BY_CATEGORY_FILE = 'goods_by_category.php';
const GOODS_BY_COMPANY_FILE = 'goods_by_company.php';
const GOODS_BY_PLACE_FILE = 'goods_by_place.php';
const GOODS_CARD_FILE = 'goods_card.php';

const ERROR = 'error.inc.php';

const EMPTY_RESPONSE = 'empty_response.inc.php';
const RESPONSE_BY_SEARCH_FILE = 'responseBySearch_search.php';
const RESPONSE_BY_SEARCH_CASE = 'responseBySearch_case.php';
const RESPONSE_BY_SEARCH_LIST_COMPANY = 'responseBySearch_list_company.inc.php';
const RESPONSE_BY_SEARCH_LIST_CATEGORY = 'responseBySearch_list_category.inc.php';
const RESPONSE_BY_SEARCH_LIST_GOODS = 'responseBySearch_list_goods.inc.php';
const RESPONSE_BY_SEARCH_LIST_PLACE = 'responseBySearch_list_place.inc.php';

const ABOUT_PARTNERS_FILE = 'about_partners.php';
const ABOUT_CONTACTS_FILE = 'about_contacts.php';

const ADMIN_LOGIN_FILE = 'admin_login.php';
const ADMIN_LOGOUT_SCRIPT = 'logout_script.php';
const ADMIN_USERS_LIST_FILE = 'users_list.php';

const COMPANY_FILTERS_JSON = 'company_filters_json.php';

const ARCHIVE_COMPANIES_FILE = 'archhive_companies.php';


/* Автозагрузчик классов */
spl_autoload_register(function ($class){
   $filename =  __DIR__ . '/' .str_replace('\\', '/', $class) . '.php';
      if (file_exists($filename)){include $filename;}
});

/* Инициализация и запуск FrontController */
$front = application\controllers\FrontController::getInstance();
$front->route();

/* Вывод данных */
echo $front->getBody();
?>


