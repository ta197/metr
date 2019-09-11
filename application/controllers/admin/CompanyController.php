<?php
namespace application\controllers\admin;

use 
    engine\core\base\View,
    application\models\NavLetters, 
    engine\core\Page,
    engine\core\Pagination, 
    engine\core\Menu,
    application\models\Category, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters;
use engine\core\App, 
engine\core\IController;

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

            $this->view->navLetters = (new NavLetters())->companyAncors();
            $this->view->counter = count($this->view->navLetters->full_list);
            
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
     * 
     */
    public function alphabetAction()
    {
        $letter = trim(urldecode($this->fc->getParams()["letter"]));
        $this->view->navLetters = (new NavLetters('company/alphabet', 'letter', $letter))
            ->companyAncors();

        $company = new Company();

        $this->view->counter = $company
            ->where('archive IS NULL AND LEFT(company, 1) = ?')
            ->count('company')->fetchColumn([$letter]);

        $page_num = isset($this->fc->getParams()["page"]) ? (int)$this->fc->getParams()["page"] : 1;
        $pag = (new Pagination('/admin/company/alphabet/letter/'.$letter))->limit($page_num);
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
