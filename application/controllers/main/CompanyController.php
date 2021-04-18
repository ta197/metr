<?php
namespace application\controllers\main;

use engine\core\base\View, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters,
    engine\core\App, 
    engine\core\IController, 
    engine\core\Pagination, 
    application\models\NavLetters, 
    engine\core\Page, 
    engine\core\Menu;
    
class CompanyController extends ParentController implements IController
{
    public function indexAction()
    {
        $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
        $pag = (new Pagination('/company/index'))->on_page(4)->limit($page_num);

        $this->view->filters = (new FiltersHandler(null))->getFilters();
        $company = new Company();
        $this->view->counter = $company
            ->where('archive IS NULL')->count('company')->fetchColumn();
    
        $this->view->navLetters = (new NavLetters())->companyAncors();
           
       
        $this->view->listCompany = $company
            ->getCompanies( 'LEFT(c.company, 1)', 'c.archive IS NULL', 'c.company')
            ->limit($pag->limit)->inEnd('limit')
            ->generator();
         
        $this->view->pagination = $pag->navparams($this->view->counter);

        $this->view->page
          ->setStyles(['pagination'])
          ->setScripts(['json2', 
                        'getXmlHttpRequest', 
                        'FilterFormRequest', 
                        'newTitle', 
                        'newForm', 
                        'newLetters',
                        'newListCompanies', 
                        'filterAjax', 
                        'newPagination']);
    }

 ///////////////////////////////////////////////////////////////////// 
   /**
    * 
    * для показа списка компаний по фильтру
    */
    public function filtersAction()
    {
        $parse = new ParseFilters();
        $search = $this->fc->getParams()["search"];

       // $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;

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

        $this->view->navLetters = (new NavLetters())
            ->getAncorsForFilter($where, $sort);
           // ->uniqueAncors($order)
           // ->isCyrillicAlphabet()->list();

        $this->view->countCompany = $this->view->navLetters->count_full;

            $this->view->listCompany = $company
                ->getCompaniesByFilters($where, $order, $sort)
                ->fetchAll();
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
          ->setScripts(['json2', 
                        'getXmlHttpRequest', 
                        'FilterFormRequest', 
                        'newTitle', 
                        'newForm', 
                        'newLetters',
                        'newListCompanies', 
                        'filterAjax', 
                        'newPagination']);
    }

///////////////////////////////////////////////////////////////////// 
    /**
     * 
     * 
     */
    public function alphabetAction()
    {
        $letter = trim(urldecode($this->fc->getParams()["letter"]));
        $this->view->navLetters = (new NavLetters('company/alphabet', 'letter', $letter))
            ->companyAncors();
//$this->b($this->view->navLetters, 1);
        $this->view->filters = (new FiltersHandler(null))->getFilters();

        $company =new Company();

        $this->view->counter = $company
            ->where('archive IS NULL AND LEFT(company, 1) = ?')
            ->count('company')->fetchColumn([$letter]);

        $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
        $pag = (new Pagination('/company/alphabet/letter/'.$letter))->limit($page_num);
        $this->view->pagination = $pag->navparams($this->view->counter);

        $this->view->listCompany = $company
            ->getCompanies( 'LEFT(company, 1)', 
                            'c.archive IS NULL AND LEFT(company, 1) = ?', 
                            'c.company')
            ->limit($pag->limit)->inEnd('limit')
            ->fetchAll([$letter]);

        $this->view->page
              ->setStyles(['pagination'])
              ->plusTitle($letter)
              ->plusHeaderTitle($letter);
    }
    
/////////////////////////////////////////////////////////////////////
    /**
     * http://metrkv1/company/archive
     * архивные, т.е. закрывшиеся, организации 
     * 
     * layout_default
     * 
     */
    public function archiveAction()
    {
        $letter = !empty($this->fc->getParams()['letter']) ? trim(urldecode($this->fc->getParams()['letter'])) :  NULL;
        $this->view->navLetters = (new NavLetters('company/archive', 'letter', $letter))->companyAncors('c.archive IS NOT NULL');
       
        $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
        
        $company = new Company();

        if(!empty($letter)){
            $this->view->counter = $company
                ->where('archive IS NOT NULL AND LEFT(company, 1) = ?')
                ->count('company')->fetchColumn([$letter]);

            $pag = (new Pagination('/company/archive/letter/'.$letter))->limit($page_num);

            $this->view->listCompany = $company
                ->getCompanies( 'LEFT(c.company, 1)', 
                                'c.archive IS NOT NULL AND LEFT(company, 1) = ?', 
                                'c.company')
                ->limit($pag->limit)->inEnd('limit')
                ->generator([$letter]);
            $this->view->page
                ->setSubHeaderTitle( '(на букву '.$letter.')' );
        }else{
            $this->view->counter = $this->view->navLetters->count_full;
            $pag = (new Pagination('/company/archive'))->limit($page_num);

            $this->view->listCompany = $company
                ->getCompanies( 'LEFT(c.company, 1)', 
                                'c.archive IS NOT NULL', 
                                'c.company')
                ->limit($pag->limit)->inEnd('limit')
                ->generator();
        }
        $this->view->pagination = $pag->navparams($this->view->counter);
      
        $this->view->page
            ->plusTitle(' | архив')
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
    public function youngAction()
    {
        $letter = !empty($this->fc->getParams()['year']) ? trim(urldecode($this->fc->getParams()['year'])) : NULL;
        $this->view->navLetters = (new NavLetters('company/young', 'year', $letter))
            ->companyAncors('c.archive IS NULL AND c.year >= ?', 'DESC', [START_WORK_YEAR]);
        
        $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
           
        $company = new Company();

        if(!empty($letter)){
            $this->view->counter = $company
                ->where('archive IS NULL AND year = ?')
                ->count('company')->fetchColumn([$letter]);

            $pag = (new Pagination('/company/young/year/'.$letter))->limit($page_num);
          
            $this->view->listCompany =  $company
                ->getCompanies('c.year', 
                                'c.archive IS NULL AND  c.year = ?', 
                                'c.year DESC, c.company ASC')
                ->limit($pag->limit)->inEnd('limit')
                ->generator([$letter]);
            $this->view->page
                ->setHeaderTitle( 'Организации, открывшиеся в '. $letter .' году');
        }else{
            $this->view->counter = $this->view->navLetters->count_full;

            $pag = (new Pagination('/company/young'))->limit($page_num);

            $this->view->listCompany =  $company
                ->getCompanies('c.year', 
                                'c.archive IS NULL AND  c.year >= ?', 
                                'c.year DESC, c.company ASC')
                ->limit($pag->limit)->inEnd('limit')
                ->generator([START_WORK_YEAR]);
        }
        
        $this->view->pagination  =  $pag->navparams($this->view->counter);

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

/////////////////////////////////////////////////////////////////////
}
