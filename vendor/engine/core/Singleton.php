<?php
namespace vendor\engine\core;

trait Singleton 
{
    private static $instance = null;

    final private function __clone(){}
    
    public static function getInstance()
    { 
        if (null === self::$instance) 
            self::$instance = new self;
        return self::$instance;
    }
}

