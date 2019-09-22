<?php
namespace application\models;
use  engine\core\db\DB, engine\core\ToString;

class Centre extends ToString 
{

    static public  $pk = 'id';
    static public $table = 'centres';
    public $addresses;
 

    static public $page_link = [
        'one' => 'address/place/name/',
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

