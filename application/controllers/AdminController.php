<?php
namespace application\controllers;

use application\models\View;

class AdminController extends ParentController implements IController
{
    
    public function indexAction()
    {
        $fc = FrontController::getInstance();
        //$this->view->listCompany = (new Company())->getQueryEachCompanies();
        //$this->view->navStatus = $this->view->navStatus('CompanyActiv', 'CompanyDesabled');
        $output = $this->view->render(DEFAULT_ADMIN_FILE);
        $fc->setBody($output);
    }

    public function loginAction()
    {
        $fc = FrontController::getInstance();
        //$this->view->listCompany = (new Company())->getQueryEachCompanies();
        //$this->view->navStatus = $this->view->navStatus('CompanyActiv', 'CompanyDesabled');
        $output = $this->view->render(ADMIN_LOGIN_FILE);
        $fc->setBody($output);
    }

    public function logoutAction()
    {
        $fc = FrontController::getInstance();
        //$this->view->listCompany = (new Company())->getQueryEachCompanies();
        //$this->view->navStatus = $this->view->navStatus('CompanyActiv', 'CompanyDesabled');
        $output = $this->view->render(ADMIN_LOGOUT_SCRIPT);
        $fc->setBody($output);
    }

     public function userlistAction()
    {
        $fc = FrontController::getInstance();
        //$this->view->listCompany = (new Company())->getQueryEachCompanies();
        //$this->view->navStatus = $this->view->navStatus('CompanyActiv', 'CompanyDesabled');
        $output = $this->view->render(ADMIN_USERS_LIST_FILE);
        $fc->setBody($output);
    }

}
