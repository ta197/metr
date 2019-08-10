<?php
namespace application\controllers\admin;

use 
    application\models\View, 
    application\models\Category, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters;
use  vendor\engine\core\App,  vendor\engine\core\IController;

class UsersController extends ParentAdminController implements IController
{

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function indexAction()
    {
        $this->view->navStatus = $this->view->navStatus(['admin'], 'UserActiv', 'UserDisabled');
        $this->view->title = 'пользователи';
        $this->view->h1 = 'Список пользователей';

    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function loginAction(){
        $this->view->title = 'авторизация';
        $this->view->h1 = 'Авторизация';
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function logoutAction(){
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
     public function adminsAction(){
        $this->view->navStatus = $this->view->navStatus(['admin'], 'UserActiv', 'UserDisabled'); 
        $this->view->title = 'список админов';
        $this->view->h1 = 'Список администраторов'; 
    }

/////////////////////////////////////////////////////////////////////
  

/////////////////////////////////////////////////////////////////////
}
