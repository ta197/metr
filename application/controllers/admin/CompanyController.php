<?php
namespace application\controllers\admin;

use 
    application\models\View, 
    application\models\Category, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters;
use engine\core\App, engine\core\IController;

class CompanyController extends ParentAdminController implements IController
{
    public $file_layout = 'admin';


    /**
     * 
     */   
    public function indexAction(){
        //try{
        $par = $this->fc->getParams();
        if(empty($par)){
            $company = new Company();
            $letters = $company->getAncorsByAlphabet();
            $this->view->counter = count($letters);
            $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));
            $this->view->listCompany = $company->getCompaniesByName();

            $this->view->navStatus = $this->view->navStatus(['admin'], 'CompanyActiv', 'CompanyDisabled');
            $this->view->title = 'организации';
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

                         //$output = $this->view->render(COMPANY_CARD_VIEW_FILE);
                        // $this->fc->setBody($output);
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
        // }catch(AppException $e){
        //     $e->err404($e, $this->fc);
        // }
    }

    /////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function createAction(){
        
        $catMenu = new Category();
            $this->view->catMenu = $catMenu->getBigCatMenu();
            
        $this->view->navStatus = $this->view->navStatus(['admin'], 'CompanyActiv', 'CompanyDisabled');
        $this->view->title = 'компании';
        $this->view->h1 = 'Добавить компанию';
    }
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}
