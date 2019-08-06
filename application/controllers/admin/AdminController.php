<?php
namespace application\controllers\admin;

use 
    application\models\View, 
    application\models\Category, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters;
use application\controllers\App, application\controllers\ParentController, application\controllers\IController;

class AdminController extends ParentController implements IController
{
    public $file_layout = 'admin';

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function indexAction()
    {
        $this->view->navStatus = $this->view->navStatus(['admin'], 'IndexActiv', 'IndexDisabled');
        $this->view->title = 'админ-панель';
        $this->view->h1 = 'Админ-панель';

    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function loginAction(){
        $this->view->title = 'авторизация';
        $this->view->h1 = 'Авторизация';
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function logoutAction(){
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
     public function userslistAction(){
        $this->view->title = 'список пользователей';
        $this->view->h1 = 'Список пользователей'; 
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
                $createCat = $cat->findOneObj($post,'name');
                if($createCat){
                    $this->view->createCat = $createCat;
                    $this->view->quote_query = $createCat->name;
                }else{
                    $this->view->createCat = false;
                    header("Location: http://{$_SERVER['HTTP_HOST']}/admin/createcategory/name/$post");
                    exit;
                }
            }
        }
        $this->view->counter = $cat->countAllCatMenu([0, 0, 1, 0, 1]);
        $this->view->catMenu = $cat->getBigCatMenu('full');

        $this->view->navStatus = $this->view->navStatus(['admin'], 'CategoryActiv', 'CategoryDisabled');
        $this->view->title = 'категории';
        $this->view->h1 = 'Категории';
    }



    /////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function createcategoryAction(){
        $newCat = $this->fc->getParams()["name"];
        $this->view->newCat = urldecode($newCat);
        $cat = new Category();
            //$this->view->catMenuIncLevelZero = $cat->getCatMenuIncLevelZero();
            //$this->view->catMenu = $cat->getBigCatMenu('full');
           
            // $name= 'utggt';
           // $id = 15;
            //$activated = 1 , $visible = 1
           // $parentObj = $cat->getCategoryObj($id);

           // $catid=  $cat-> createCategory($name, $parentObj, $activated = 1 , $visible = 1); 
            
//SELECT WHERE name = $name;

            // echo '<pre>';
            // print_r($catid);
            // echo '</pre>';
            // exit;

        $this->view->title = 'новая категория';
        $this->view->h1 = 'Добавить категорию '.$this->view->quote_ucfirst($this->view->newCat);    
        $this->view->navStatus = $this->view->navStatus(['admin'], 'CategoryActiv', 'CategoryDisabled');
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
            }
        }
        
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */   
    public function companyAction(){
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
    public function createcompanyAction(){
        
        $catMenu = new Category();
            $this->view->catMenu = $catMenu->getBigCatMenu();
            
        $this->view->navStatus = $this->view->navStatus(['admin'], 'CompanyActiv', 'CompanyDisabled');
        $this->view->title = 'компании';
        $this->view->h1 = 'Добавить компанию';
    }
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}
