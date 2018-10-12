<?php
namespace application\controllers;

use application\models\View, application\models\Company, application\models\Address, application\models\FiltersHandler, application\models\ParseFilters;

class CompanyController extends ParentController implements IController
{
    
    public function indexAction()
    {
        $fc = FrontController::getInstance();

        $this->view->filters = (new FiltersHandler(null))->getFilters();
        $company =new Company();
        //$listLettersLegal = $company->getAllLettersAndLegal();
        $fildAncor = 'LEFT(c.company, 1)';
        $letters = $company->getAncors($fildAncor);
        $this->view->countCompany = count($letters);
        $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));
        //var_dump($this->view->listLetters);
        //$this->view->countCompany = count($listLettersLegal);
       // $this->view->listLetters = $company->listUniqLetters($listLettersLegal);
        $this->view->listCompany = $company->getEachCompanies($fildAncor);
        $this->view->navStatus = $this->view->navStatus('CompanyActiv', 'CompanyDisabled');
        $output = $this->view->render(DEFAULT_COMPANY_FILE);
        $fc->setBody($output);
    }

  //для показа спискка коммппаний по фильтру//////////////////////////////////////////////////////////////////////

    public function filtersAction()
    {
        $fc = FrontController::getInstance();
       
        $parse = new ParseFilters();
        $search = $fc->getParams()["search"];
       
        if(!$search) $decode = $parse->decodeFilters();
        else $decode = $parse->queryFilters();

        $filters= new FiltersHandler($decode);
            $where = $filters->combineWhere()->getWhere();
            $sort = $filters->getSort();
            $order = $filters->getOrder();
            $this->view->h1 = $filters->getTitle();
            $this->view->filters = $filters->getFilters();
            
        $this->view->error = $filters->getError();
        if($this->view->error){
            $this->view->filters = $filters->getFilters();
            $this->view->countCompany = 0;
        }else{
            $company = new Company();
            $fildAncor = 'LEFT(c.company, 1)';
            $letters = $company->getAncors($fildAncor, $where, $sort);
            $this->view->countCompany = count($letters);
            $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters, $order));
            $this->view->listCompany = $company->getCompaniesByFilters($where, $order, $sort);
        }
        
        if($search){
            $this->view->navStatus = $this->view->navStatus('CompanyActiv', 'CompanyDisabled');
            $output = $this->view->render(DEFAULT_COMPANY_FILE);
        }else{
            $output = $this->view->render(COMPANY_FILTERS_JSON);
        }
        
        $fc->setBody($output);
    }
    
//закрывшиеся организации ///////////////////////////////////////////////////////////
    
    public function archiveAction(){
        $fc = FrontController::getInstance();

        $company = new Company();
        $fildAncor = 'LEFT(c.company, 1)';
        $where = 'WHERE c.archive IS NOT NULL ';
        $letters = $company->getAncors($fildAncor, $where);
        $this->view->countCompany = count($letters);
       
        $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));

        $this->view->listCompany = $company->getEachCompanies($fildAncor, $where);
       
        $output = $this->view->render(ARCHIVE_COMPANIES_FILE);
        $fc->setBody($output);
    } 

    
// организации, начавшие работу с определенного года и последующие //////////////////

    public function youngAction(){
        $fc = FrontController::getInstance();

        $company =new Company();
        
        $where = 'WHERE c.archive IS NULL ';
        $andWhere = ' AND  c.year >= :years';
        $order = 'c.year DESC, c.company ASC';
        $years = 2016;
        $q = ['years' => $years];
        $fildAncor = 'c.year';
        
        $letters = $company->getAncors($fildAncor, $where, 'DESC', $andWhere, $q);
        $this->view->countCompany = count($letters);
        $this->view->listLetters = $company->uniqueAncors($letters);

        $this->view->listCompany = $company->getEachCompanies($fildAncor, $where, $andWhere, $order, $q);
       
        $output = $this->view->render(YOUNG_COMPANIES_FILE);
        $fc->setBody($output);
    }
    
//карточка организации //////////////////////////////////////////////////////////////////////

   public function cardAction()
   {
       $fc = FrontController::getInstance();
       $id = $fc->getParams()["c"];
       //$view = new View();
       $this->view->p = (new Address())->getPlacesByCompanyId($id);
       $this->view->c = (new Company())->getTitleCompanyById($id);
       $output = $this->view->render(COMPANY_CARD_VIEW_FILE);
       $fc->setBody($output);
   }

}
