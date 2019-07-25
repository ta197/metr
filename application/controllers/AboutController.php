<?php
namespace application\controllers;

use application\models\View;

class AboutController extends ParentController implements IController
{
    //public $vObj;
 /////////////////////////////////////////////////////////////////////   
    public function indexAction()
    {
       
      $this->view->navStatus = $this->view->navStatus(['about'], 'AboutActiv', 'AboutDisabled');
      $this->view->h1 = 'О проекте';
      $this->view->title = 'о проекте';
      //$this->view->file_layout = LAYOUT;
        //$output = $this->view->render(DEFAULT_ABOUT_FILE);
       // $this->fc->setBody($output);
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
        $output = $this->view->render(ABOUT_PARTNERS_FILE);
        $this->fc->setBody($output);
    }

    

}