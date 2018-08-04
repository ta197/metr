<?php
namespace application\models;

trait Singleton 
{
    private static $instance;

    private function __clone(){}
    
    public static function getInstance()
    { 
        if (null === self::$instance) 
            self::$instance = new self;
        return self::$instance;
    }
}

