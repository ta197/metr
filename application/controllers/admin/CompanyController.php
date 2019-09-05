<?php
namespace application\controllers\admin;

use 
    engine\core\base\View, 
    application\models\Category, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters;
use engine\core\App, engine\core\IController;

class CompanyController extends ParentAdminController implements IController
{

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */   
    public function indexAction()
    {
        $par = $this->fc->getParams();
        if(empty($par)){
            $company = new Company();
            $letters = $company->getAncorsByAlphabet()->fetchAll();
            $this->view->counter = count($letters);
            $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));
            
            $this->view->listCompany = $company
                ->getCompanies( 'LEFT(c.company, 1)', 'c.archive IS NULL', 'c.company')
                ->generator();

            $this->view->h1 = 'Организации';    
           
        }else{
            if(count($par)>1){
                throw new \Exception("Лишние параметры", 404);
            }
            if(isset($this->fc->getParams()["name"])){
                $id = (int)$this->fc->getParams()["name"];
                if(!empty($id)){
                    $this->view->name = (new Company())->getTitleCompanyById($id);
                    if($this->view->name){
                         $this->view->p = (new Address())->getPlacesByCompanyId($id);
                    }
                    else{
                        throw new \Exception("Нет организации с таким id", 404);
                    }
                }else{
                    throw new \Exception("id организации не число", 404);
                }
            } else{
                throw new \Exception("Нет параметра name организации", 404);
            }
        }  
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function createAction(){
        
        $catMenu = new Category();
        $this->view->catMenu = $catMenu
            ->fields(['name', 'cat_id', 'level', 'activated', 'parent_id', 'lft', 'rgt'])
            ->where('level>? AND visible= ?')->order_by("lft")->select()->generator([0, 1]);
            
    }

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}
