<?php
namespace application\controllers;

use application\controllers\Registry;
use application\controllers\ErrorHandler;

class App
{
    public static $app;
    
    public function __construct(){
        self::$app = Registry::getInstance();
        new ErrorHandler();
    }

    
}