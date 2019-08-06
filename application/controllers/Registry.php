<?php
namespace application\controllers;
use application\controllers\Singleton;
use libs\Cache;

class Registry
{
    use Singleton;    
    public static $objects = [];
   
    protected function __construct(){
        require_once CONFIG;
        foreach($config['components'] as $name => $component){
            self::$objects[$name] = new $component;
        }
    }

    public function __get($name){
        if(is_object(self::$objects[$name])){
            return self::$objects[$name];
        }
    }

    public function __set($name, $obj){
        if(!isset(self::$objects[$name])){
            self::$objects[$name] = new $obj;
        }
    }

}