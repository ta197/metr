<?php
namespace engine\core;
use  engine\core\base\Model;

class ToString extends Model
{
    static public $string = [];
    static public $delim = ', ';

    static public $page_link = [
        'one' => '',
        'list_full' => '',
    ];

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
    public function __toString()
    {
        $arrString = $this->arrOrder();
        return implode(static::$delim, $arrString);  
    }

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
    public function arrOrder()
    {
        //$delim = array_shift($this->string);
        $string = [];
          foreach(static::$string as $k=>$prop){
              if(isset($this->$prop)){
                  $string[$k]=$this->$prop;
              }
          }
          return $string;  
    }
  
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
    public function arrProps()
    {
        //$delim = array_shift($this->string);
        $string = [];
          foreach(static::$string as $k=>$prop){
              if(isset($this->$prop)){
                  $string[$prop]=$this->$prop;
              }
          }
          return $string;  
    }
  
  /////////////////////////////////////////////////////////////////////  

/////////////////////////////////////////////////////////////////////
}

