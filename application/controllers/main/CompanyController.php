<?php
namespace application\controllers\main;

use 
    engine\core\base\View, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters;
use engine\core\App, engine\core\IController, engine\core\Pagination, engine\core\Page, engine\core\Menu;
    
class CompanyController extends ParentController implements IController
{
       
    public function indexAction()
    {
        $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
    
        $this->view->filters = (new FiltersHandler(null))->getFilters();
        $company =new Company();
        $companyCount = $company->where('archive IS NULL')->count('company')->fetchColumn();
    
        $letters = $company->getAncorsByAlphabet()->fetchAll();
        //$this->view->counter = count($letters);

        $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));

		$pagination = new Pagination('/company/index');
        $limit = $pagination->on_page(2)->page_num($page_num)->page();
       
        $this->view->listCompany = $company
            ->getCompanies( 'LEFT(c.company, 1)', 'c.archive IS NULL', 'c.company')
            ->limit($limit)->inEnd('limit')
            ->generator();
         
      $this->view->pagination  =  $pagination->navparams($companyCount);
      
      $this->view->page
          ->setStyles(['pagination'])
          ->setScripts(['json2', 'getXmlHttpRequest', 'FilterFormRequest', 'newTitle', 'newForm', 'newLetters','newListCompanies', 'filterAjax', 'newPagination']);
          
    //$this->b($this->view, 1);

    }

 ///////////////////////////////////////////////////////////////////// 
/**
 * 
 * для показа спискка коммппаний по фильтру
 */
    public function filtersAction()
    {
        $parse = new ParseFilters();
        $search = $this->fc->getParams()["search"];

        $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
        //$pagination = new Pagination('/company/filters/search');
        //$limit = $pagination->on_page(2)->page_num($page_num)->page();
        //H::bug($limit, 1);

        if(!$search) $decode = $parse->decodeFilters();
        else $decode = $parse->queryFilters();

        $filters= new FiltersHandler($decode);
            $where = $filters->combineWhere()->getWhere();
            $sort = $filters->getSort();
            $order = $filters->getOrder();
            $this->view->header_title = $filters->getTitle();
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

            $this->view->listCompany = $company->getCompaniesByFilters($where, $order, $sort)->fetchAll();
            $companyCount = count($this->view->listCompany);
            //$this->view->navparams  =  $pagination->navparams($companyCount);
        }

        if($search){
            $this->file_layout = 'index_company';
            $this->file_view = 'index_company';
        }else{
          $this->file_layout = false;
          $this->file_view  = 'company_filters_json';
        }

        $this->view->page
          ->setStyles(['pagination'])
          ->setScripts(['json2', 'getXmlHttpRequest', 'FilterFormRequest', 'newTitle', 'newForm', 'newLetters','newListCompanies', 'filterAjax', 'newPagination']);
          
    //$this->b($this->view->page->id_page);
    }

 ///////////////////////////////////////////////////////////////////// 
/**
 * 
 * 
 */
public function alphabetAction()
{
    $letter = trim(urldecode($this->fc->getParams()["letter"]));
    $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
    $pagination = new Pagination('/company/alphabet/letter/'.$letter);
    $limit = $pagination->on_page(2)->page_num($page_num)->page();
    $this->view->filters = (new FiltersHandler(null))->getFilters();
    $company =new Company();

    $this->view->counter = $company->where('archive IS NULL AND LEFT(company, 1) = ?')->count('company')->fetchColumn([$letter]);

    $letters = $company->getAncorsByAlphabet()->fetchAll();
    //$this->view->counter = count($letters);

    $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));

    $this->view->listCompany = $company
        ->getCompanies( 'LEFT(company, 1)', 'c.archive IS NULL AND LEFT(company, 1) = ?', 'c.company')
        ->limit($limit)->inEnd('limit')
        ->fetchAll([$letter]);
   
    $this->view->pagination  =  $pagination->navparams($this->view->counter);

    $this->view->page
          ->setStyles(['pagination'])
          ->setScripts(['json2', 'getXmlHttpRequest', 'FilterFormRequest', 'newTitle', 'newForm', 'newLetters','newListCompanies', 'filterAjax', 'newPagination'])
          ->plusTitle($letter)
          ->plusHeaderTitle($letter);
    $this->file_view = 'index_company';

}

    
/////////////////////////////////////////////////////////////////////
    /**
     * http://metrkv1/company/archive
     * архивные, т.е. закрывшиеся, организации 
     * 
     * layout_default
     * 
     */
    public function archiveAction(){
        $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
        $company = new Company();
        $letters = $company->getAncorsByAlphabet('IS NOT NULL')->fetchAll();
        $this->view->counter = count($letters);
        $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));

        $pagination = new Pagination('/company/archive');
        $limit = $pagination->on_page(2)->page_num($page_num)->page();

        $this->view->listCompany = $company
            ->getCompanies( 'LEFT(c.company, 1)', 'c.archive IS NOT NULL', 'c.company')
            ->limit($limit)->inEnd('limit')
            ->generator();
        
        $this->view->pagination  =  $pagination->navparams($this->view->counter);

       $this->view->title .= ' в архиве';

        $this->view->page
            ->setTitle( $this->view->title)
            //->setScripts(['newPagination'])
            ->setStyles(['pagination']);
    } 

    
/////////////////////////////////////////////////////////////////////
/**
 * http://metrkv1/company/young
 * новые организации - год, с какого считать новыми 
 *      в файле \application\constans.php
 * организации, начавшие работу с определенного года и последующие
 * 
 * layout_default 
 */
    public function youngAction(){
        $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
        
        $company = new Company();
        $letters = $company->getAncorsByYears()->fetchAll([START_WORK_YEAR]);
        $this->view->counter = count($letters);
        $this->view->listLetters = $company->uniqueAncors($letters);

		$pagination = new Pagination('/company/young');
        $limit = $pagination->on_page(2)->page_num($page_num)->page();
       
        $this->view->listCompany = $company
            ->getCompanies('c.year', 'c.archive IS NULL AND  c.year >= ?', 'c.year DESC, c.company ASC')
            ->limit($limit)->inEnd('limit')
            ->generator([START_WORK_YEAR]);
         
      $this->view->pagination  =  $pagination->navparams($this->view->counter);
      
      $this->view->page
          ->setStyles(['pagination']);

    }
    
/////////////////////////////////////////////////////////////////////
/**
 * http://metrkv1/company/card/name/9
 * карточка организации
 * layout с картами company_card
 * параметр name (обязательный)
 */
   public function cardAction()
   {
        $id = $this->checkOneParam('name');
        $this->view->name = (new Company())->getTitleCompanyById($id);
        if(!$this->view->name)
            throw new \Exception("нет такой компании", 404);

    //$d = App::$app->cache->get('d');  
    
        $this->view->p = (new Address())->getPlacesByCompanyId($id);
       // App::$app->cache->set('d', $this->view->p);
    
       $this->view->countPlaces = count($this->view->p);
       
        $this->file_layout = 'company_card'; //map
        
        $this->view->page
            ->plusTitle('| '.$this->view->name->company_name)
            ->setHeaderTitle($this->view->name->company_name);
   }

 /////////////////////////////////////////////////////////////////////  

}
