<?php
/* Пути по-умолчанию для поиска файлов */
set_include_path(get_include_path()
					.PATH_SEPARATOR.'application/controllers'
                    .PATH_SEPARATOR.'application/models'
                    .PATH_SEPARATOR.'application/views/layouts'
                    .PATH_SEPARATOR.'application/base'
                    .PATH_SEPARATOR.'application/views/metr'
                    .PATH_SEPARATOR.'application/views/petrova'
                    .PATH_SEPARATOR.'application/views/admin');

include_once 'application/constants.php';

/* Автозагрузчик классов */
spl_autoload_register(function ($class){
   $filename =  __DIR__ . '/' .str_replace('\\', '/', $class) . '.php';
      if (file_exists($filename)){include $filename;}
});

new  vendor\engine\core\App;

/* Инициализация и запуск FrontController */
$front =  vendor\engine\core\FrontController::getInstance();

//try{
    //Есть ли параметры и их значения?
    $front->checkParams();
    $front->route();
//}catch(application\controllers\AppException $e){
    //$e->err404($e, $front);
//}


/* Вывод данных */
echo $front->getBody();



