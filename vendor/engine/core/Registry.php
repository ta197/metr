<?php
namespace engine\core;

use engine\core\Singleton;
use engine\libs\Cache;
use application\config\config;

class Registry
{
    use Singleton;
        
    public static $objects = [];

/////////////////////////////////////////////////////////////////////  
    protected function __construct(){
        require_once CONFIG;
        foreach($config['components'] as $name => $component){
            self::$objects[$name] = new $component;
        }
    }

/////////////////////////////////////////////////////////////////////
    public function __get($name){
        if(is_object(self::$objects[$name])){
            return self::$objects[$name];
        }
    }

/////////////////////////////////////////////////////////////////////
    public function __set($name, $obj){
        if(!isset(self::$objects[$name])){
            self::$objects[$name] = new $obj;
        }
    }
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}