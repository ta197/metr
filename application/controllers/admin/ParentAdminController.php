<?php
namespace application\controllers\admin;

use application\models\View,  vendor\engine\core\RouteController;

class ParentAdminController extends RouteController
{
    public $file_layout = 'admin';

    public function __constuct(){
        parent::__constuct();
       
    }

}