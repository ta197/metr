<?php
namespace engine\libs;

class H
{
    public static function redirect($http = false){
        if($http){
            $redirect = $http;
        }else{
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/";  
        }
        header("Location: $redirect");
        exit;
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
    public static function bug($arr, $die = false){
        echo '<pre>'.print_r($arr, true).'</pre>';
        if($die) die;
     }

     //engine\libs\H::db($arr, $die = false);
 
 /////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
    public static function h($str){
       return htmlspecialchars($str, ENT_QUOTES);
    }

/////////////////////////////////////////////////////////////////////
}

