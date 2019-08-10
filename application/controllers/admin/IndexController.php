<?php
namespace application\controllers\admin;

use  vendor\engine\core\App,  vendor\engine\core\IController;

class IndexController extends ParentAdminController implements IController
{

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function indexAction()
    {
        $this->view->navStatus = $this->view->navStatus(['admin'], 'IndexActiv', 'IndexDisabled');
        $this->view->title = 'админ-панель';
        $this->view->h1 = 'Админ-панель';

    }

}
