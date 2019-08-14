<?php
namespace application\controllers\main;

use application\models\View;
use  engine\core\App,  engine\core\IController;

class AboutController extends ParentController implements IController
{
 /////////////////////////////////////////////////////////////////////   
    public function indexAction()
    {
      $this->view->navStatus = $this->view->navStatus(['about'], 'AboutActiv', 'AboutDisabled');
      $this->view->h1 = 'О проекте';
      $this->view->title = 'о проекте';
    }
/////////////////////////////////////////////////////////////////////
    public function contactsAction()
    {
        $this->view->navStatus = $this->view->navStatus(['about'],'ContactsActiv', 'ContactsDisabled');
        $this->view->h1  = 'Контакты';
        $this->view->title = 'контакты';
    }
/////////////////////////////////////////////////////////////////////
    public function partnersAction()
    {
        $this->view->navStatus = $this->view->navStatus(['about'], 'PartnersActiv', 'PartnersDisabled');
        $this->view->h1 = 'Рекламодателям';
        $this->view->title = 'рекламодателям';
    }

    

}