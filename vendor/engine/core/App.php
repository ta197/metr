<?php
namespace  vendor\engine\core;

use  vendor\engine\core\Registry;
use vendor\engine\core\ErrorHandler;

class App
{
    public static $app;
    
    public function __construct(){
        self::$app = Registry::getInstance();
        new ErrorHandler();
    }

    
}