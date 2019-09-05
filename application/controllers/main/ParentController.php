<?php
namespace application\controllers\main;

use engine\core\base\View,  application\models\User, engine\core\base\Controller;
use engine\core\FrontController;


class ParentController extends Controller
{
    //public $base_title = 'm2';
 
    public function __construct($fc){
        parent::__construct($fc);
            //$this->isRole();  
    }
   

}