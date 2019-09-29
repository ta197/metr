<?php

include_once '.././application/constants.php';

/* Автозагрузчик классов */
require __DIR__.'/../vendor/autoload.php';

new  engine\core\App;

/* Инициализация и запуск FrontController */
$front = engine\core\FrontController::getInstance();
$front->run();

/* Вывод данных */
echo $front->getBody();



