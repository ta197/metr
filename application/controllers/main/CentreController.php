<?php
namespace application\controllers\main;

use engine\core\base\View, 
    application\models\Company, 
    application\models\Address, 
    application\models\Centre, 
    application\models\ParseFilters,
    engine\core\App, 
    engine\core\IController, 
    engine\core\Pagination, 
    application\models\NavLetters, 
    engine\core\Page, 
    engine\core\Menu;
    
class CentreController extends ParentController implements IController
{
    
/////////////////////////////////////////////////////////////////////
    /**
    *
    */    
    public function indexAction()
    {
        $this->view->centres = (new Centre())
            ->fields()->select()->fetchAll();
        $this->view->counter = count($this->view->centres);
    }

/////////////////////////////////////////////////////////////////////
    /**
    *
    */
    public function cardAction()
    {
        $id = $this->checkOneParam('id');
        $this->view->centre = (new Centre())->getObjById($id);
        if(!$this->view->centre)
            throw new \Exception("нет такого центра", 404);
        $this->view->name = $this->view->centre->name_center;
        $company = (new Company());
        $this->view->companies = $company
            ->getCompaniesByCentre()
            ->fetchAll([$id]);
       $this->view->countCompanies = count($this->view->companies);
       
        $this->file_layout = 'company_card'; //map
        
        $this->view->page
            ->plusTitle('| '.$this->view->centre->name_center)
            ->setHeaderTitle($this->view->centre->name_center)
            ->setSubHeaderTitle($this->view->centre->address);
    }

///////////////////////////////////////////////////////////////////// 

/////////////////////////////////////////////////////////////////////
}
