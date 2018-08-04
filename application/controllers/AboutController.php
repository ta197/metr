<?php
namespace application\controllers;

use application\models\View;

class AboutController extends ParentController implements IController
{
    
    public function indexAction()
    {
        $fc = FrontController::getInstance();

        $this->view->navStatus = $this->view->navStatus('AboutActiv', 'AboutDisabled');
        $output = $this->view->render(DEFAULT_ABOUT_FILE);
        $fc->setBody($output);
    }

    public function contactsAction()
    {
        $fc = FrontController::getInstance();
        $this->view->navStatus = $this->view->navStatus('ContactsActiv', 'ContactsDisabled');
        $output = $this->view->render(ABOUT_CONTACTS_FILE);
        $fc->setBody($output);
    }

    public function partnersAction()
    {
        $fc = FrontController::getInstance();
        $this->view->navStatus = $this->view->navStatus('PartnersActiv', 'PartnersDisabled');
        $output = $this->view->render(ABOUT_PARTNERS_FILE);
        $fc->setBody($output);
    }

    

}