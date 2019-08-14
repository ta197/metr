<?php
namespace application\controllers\admin;

use 
    application\models\View, 
    application\models\Category, 
    application\models\Company, 
    application\models\Address, 
    application\models\FiltersHandler, 
    application\models\ParseFilters;
use  engine\core\App,  engine\core\IController;

class CategoryController extends ParentAdminController implements IController
{



/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function indexAction(){
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
                    header("Location: http://{$_SERVER['HTTP_HOST']}/admin/category/create/name/$post");
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
    public function createAction(){
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
}
