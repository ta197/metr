<?php
namespace application\controllers\admin;

use application\controllers\App, application\controllers\ParentController, application\controllers\IController;

class IndexController extends ParentController implements IController
{
    public $file_layout = 'admin';

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
