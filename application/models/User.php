<?php
namespace application\models;
use  vendor\engine\core\base\DB, vendor\engine\core\Model;

class User extends Model
{
   public $attributes = [
        'login' => '',
        'password' => '',
        'email' => '',
        'name' => '',
        'role' => 'user'
   ];

   public $rules = [
        'required' => [
            ['login'],
            ['password'],
            ['email'],
            ['name'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['password', 6],
        ]
   ];
    
/////////////////////////////////////////////////////////////////////
     /**
     * 
     */   
    //public function __construct(){
        
    //}

/////////////////////////////////////////////////////////////////////

        public function checkUnique(){
            $user =
        }
   
/////////////////////////////////////////////////////////////////////
}

