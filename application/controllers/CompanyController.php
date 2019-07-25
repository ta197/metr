<?php
namespace application\controllers;

use 
    application\models\View, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters;

class CompanyController extends ParentController implements IController
{
    
    public function indexAction()
    {
        $this->view->filters = (new FiltersHandler(null))->getFilters();
        $company =new Company();
        //$listLettersLegal = $company->getAllLettersAndLegal();
        //$fildAncor = 'LEFT(c.company, 1)';
        $this->view->h1 = 'Все организации справочника';
        $this->view->title = 'компании';
        $letters = $company->getAncorsByAlphabet();
        $this->view->counter = count($letters);
        $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));
        
        $this->view->listCompany = $company->getCompaniesByName();
        $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv', 'CompanyDisabled');
        $this->file_layout = 'index_company';
        $this->file_view = 'index_company';
      
    }

 ///////////////////////////////////////////////////////////////////// 
/**
 * 
 * для показа спискка коммппаний по фильтру
 */
  public function filtersAction()
  {
    //var_dump(  $__POST ); die;
      $parse = new ParseFilters();
      //var_dump(  $parse ); die;
      $search = $this->fc->getParams()["search"];
    // var_dump(  $search ); die;
     
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
    
          $letters = $company->getAncorsForFilter($where, $sort);
          $this->view->countCompany = count($letters);
          $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters, $order));
          $this->view->listCompany = $company->getCompaniesByFilters($where, $order, $sort);
      }
      
      if($search){
          $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv', 'CompanyDisabled');
          $this->file_layout = 'index_company';
          $this->file_view = 'index_company';
          //$output = $this->view->render(DEFAULT_COMPANY_FILE);
      }else{
        $this->file_layout = false;
        $this->file_view  = COMPANY_FILTERS_JSON;
//exit;
      }

      // echo '<pre>';
     // print_r($this->file_view);
      // echo '</pre>';
      
  }
  
    
/////////////////////////////////////////////////////////////////////
    /**
     * http://metrkv1/company/archive
     * архивные, т.е. закрывшиеся, организации 
     */
    public function archiveAction(){

        $company = new Company();
        $letters = $company->getAncorsByAlphabet($archive ='IS NOT NULL');
        $this->view->counter = count($letters);
       
        $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));

        $this->view->listCompany = $company->getCompaniesByName($archive = 'IS NOT NULL');
        $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv');
        $this->view->title = 'архивные организации';
        $this->view->h1 = 'Организации, прекратившие работу';
    } 

    
/////////////////////////////////////////////////////////////////////
/**
 * http://metrkv1/company/young
 * новые организации - год, с какого считать новыми 
 *      в файле \application\constans.php
 * организации, начавшие работу с определенного года и последующие 
 */
    public function youngAction(){
        
        $company = new Company();
        $letters = $company->getAncorsByYears(START_WORK_YEAR);
        $this->view->counter = count($letters);
        $this->view->listLetters = $company->uniqueAncors($letters);

        $this->view->listCompany = $company->getCompaniesByYears(START_WORK_YEAR);
        $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv');
        $this->view->title = 'новые организации';
        $this->view->h1 = 'Новые организации';
    }
    
/////////////////////////////////////////////////////////////////////
/**
 * http://metrkv1/company/card/name/9
 * карточка организации
 */
   public function cardAction()
   {
    try{
        if(isset($this->fc->getParams()["name"])){
            $id = $this->fc->getParams()["name"];
            $id = (int)$id;
            if(empty ($id))
                throw new AppException("card name !num");
        }else{
            throw new AppException("card !name");
        }
      
       $this->view->name = (new Company())->getTitleCompanyById($id);
       if($this->view->name){
            $this->view->p = (new Address())->getPlacesByCompanyId($id);
            $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv');
            $this->view->title = $this->view->name->company_name;
            $this->view->h1 = $this->view->name->company_name;
            $this->view->countPlaces = count($this->view->p);

            $this->view->file_layout = 'company_card';
       }else{
            throw new AppException("!company");
       }
       
    }catch(AppException $e){
        $e->err404($e, $this->fc->modul);
    }
   }

 /////////////////////////////////////////////////////////////////////  

}
