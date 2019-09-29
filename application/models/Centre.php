<?php
namespace application\models;
use  engine\core\db\DB, engine\core\ToString;

class Centre extends ToString 
{

    static public  $pk = 'id';
    static public $table = 'centres';
    public $address;

    public $name_center;

    static public $sql;
    static public $coreProps = ['id', 'name_center', 'address', 'site'];
    static public $page_link = [
        'one' => 'centre/card/id/',
    ];
    
    static public $string = ['name_center', 'address'];
  

/////////////////////////////////////////////////////////////////////
    /**
    * 
    */    
    //public function __construct(){
        
    //}
   
 
    
 /////////////////////////////////////////////////////////////////////
}

