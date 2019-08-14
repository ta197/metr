<?php
namespace application\controllers\admin;

use application\models\View,  application\models\User, engine\core\RouteController;
use engine\libs\H;
use engine\core\FrontController;

class ParentAdminController extends RouteController
{
    public $file_layout = 'admin';

    public function __construct($fc){
        parent::__construct($fc);
        //H::db($this->route,1);
        if(!User::isAdmin() && $this->route['action'] != 'login'){
            H::redirect('/admin/user/login');
        }
       
    }

}