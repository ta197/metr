<?php
namespace  engine\core;

use  engine\core\Registry;
use engine\core\ErrorHandler;
use engine\libs\H;

class App
{
    public static $app;
    public static $h;

    public function __construct(){
        session_start();

        self::$app = Registry::getInstance();
        new ErrorHandler();
        self::$h = new H;
    }

    
}