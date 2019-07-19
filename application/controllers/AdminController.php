<?php
namespace application\controllers;

use 
    application\models\View, 
    application\models\Category, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters;

class AdminController extends ParentController implements IController
{

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function indexAction()
    {
        $this->view->navStatus = $this->view->navStatus(['admin'], 'IndexActiv', 'IndexDisabled');
        $this->view->title = 'админ-панель';
        $this->view->h1 = 'Админ-панель';
        $output = $this->view->render(DEFAULT_ADMIN_FILE);
        $this->fc->setBody($output);
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function loginAction(){
        $this->view->title = 'авторизация';
        $this->view->h1 = 'Авторизация';
        $output = $this->view->render(ADMIN_LOGIN_FILE);
        $this->fc->setBody($output);
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function logoutAction(){
        $output = $this->view->render(ADMIN_LOGOUT_SCRIPT);
        $this->fc->setBody($output);
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
     public function userlistAction(){
        $this->view->title = 'список пользователей';
        $this->view->h1 = 'Список пользователей'; 
        $output = $this->view->render(ADMIN_USERS_LIST_FILE);
        $this->fc->setBody($output);
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function categoryAction(){
        $cat = new Category();
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
            if(!empty($_POST['createCat'])){
                $post = trim( strip_tags( $_POST['createCat'] ));
                $cat = new Category();
                $createCat = $cat->getRowByField('name', $post);
                if($createCat){
                    $this->view->createCat = $createCat;
                    $this->view->quote_query = $createCat->name;
                }else{
                    $this->view->createCat = false;
                    header("Location: http://{$_SERVER['HTTP_HOST']}/admin/createcategory");
                    exit;
                }
            }
        }
        $this->view->counter = $cat->countAllCatMenu([0, 0, 1, 0, 1]);
        $this->view->catMenu = $cat->getBigCatMenu('full');
        $this->view->navStatus = $this->view->navStatus(['admin'], 'CategoryActiv', 'CategoryDisabled');
        $this->view->title = 'категории';
        $this->view->h1 = 'Категории';
        $output = $this->view->render(ADMIN_CATEGORY_FILE);
        $this->fc->setBody($output);
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function createcompanyAction(){
        
        $catMenu = new Category();
            $this->view->catMenu = $catMenu->getBigCatMenu();
            
        $this->view->navStatus = $this->view->navStatus(['admin'], 'CategoryActiv', 'CategoryDisabled');
        $this->view->title = 'компании';
        $this->view->h1 = 'Добавить компанию';
        $output = $this->view->render(ADMIN_CREATE_COMPANY_FILE);
        $this->fc->setBody($output);
    }

    /////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function createcategoryAction(){
        
        $cat = new Category();
            //$this->view->catMenu = $catMenu->getBigCatMenu();
            $name= 'utggt';
            $id = 15;
            //$activated = 1 , $visible = 1
            $parentObj = $cat->getCategoryObj($id);

            $catid=  $cat-> createCategory($name, $parentObj, $activated = 1 , $visible = 1); 
            
//SELECT WHERE name = $name;

            // echo '<pre>';
            // print_r($catid);
            // echo '</pre>';
            // exit;

        $this->view->title = 'новая категория';
        $this->view->h1 = 'Добавить категорию';    
        $this->view->navStatus = $this->view->navStatus(['admin'], 'CategoryActiv', 'CategoryDisabled');
        $output = $this->view->render(ADMIN_CREATE_CATEGORY_FILE);
        $this->fc->setBody($output);
    }

     /////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function checkcategoryAction(){
        if($_POST['category']){
            $post = trim( strip_tags( $_POST['category'] ));
            $cat = new Category();
            $category = $cat->getRowByField('name', $post);
            if($category){
                $this->view->category = $category;
            }else{
                $this->view->category = 'no';
                $this->view->navStatus = $this->view->navStatus(['admin'], 'CompanyActiv');
                $output = $this->view->render(ADMIN_CREATE_CATEGORY_FILE);
                $this->fc->setBody($output);
            }
        }

        
            //$this->view->catMenu = $catMenu->getBigCatMenu();
        
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */   
    public function companyAction(){
        try{
        $par = $this->fc->getParams();
        if(empty($par)){
            $company = new Company();
            $letters = $company->getAncorsByAlphabet();
            $this->view->counter = count($letters);
            $this->view->listLetters = $company->isCyrillicAlphabet($company->uniqueAncors($letters));
            $this->view->listCompany = $company->getCompaniesByName();
            $this->view->title = 'организации';
            $this->view->h1 = 'Организации';    
            $this->view->navStatus = $this->view->navStatus(['admin'], 'CompanyActiv', 'CompanyDisabled');
            $output = $this->view->render(ADMIN_COMPANY_FILE);
            $this->fc->setBody($output);
        }else{
            if(count($par)>1){
                throw new AppException("Лишние параметры");
            }
            if(isset($this->fc->getParams()["name"])){
                $id = (int)$this->fc->getParams()["name"];
                if(!empty($id)){
                    $this->view->name = (new Company())->getTitleCompanyById($id);
                    if($this->view->name){
                         $this->view->p = (new Address())->getPlacesByCompanyId($id);

                         $output = $this->view->render(COMPANY_CARD_VIEW_FILE);
                         $this->fc->setBody($output);
                    }
                    else{
                        throw new AppException("Нет организации с таким id");
                    }
                }else{
                    throw new AppException("id организации не число");
                }
            } else{
                throw new AppException("Нет параметра name организации");
            }
        }  
        }catch(AppException $e){
            $e->err404($e, $fc->modul);
        }
    }
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}
