<?php
namespace application\controllers\admin;

use 
    engine\core\base\View, 
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
        if($this->IsPost()){
            if(!empty($_POST['createCat'])){
                $post = trim( strip_tags( $_POST['createCat'] ));
                //$cat = new Category();
                $createCat = $cat
                //->fields(['name'])
                    ->where('name LIKE ?')->select()->fetchObject([$post]);
              
                if($createCat){
                    $this->view->createCat = $createCat;
                    $this->view->quote_query = $createCat->name;
                   // var_dump($createCat); die;
                }else{
                   $this->view->createCat = false;
                   $this->redirect("http://{$_SERVER['HTTP_HOST']}/admin/category/create/name/$post");
                    exit;
                }
            }
        }
       $this->view->counter = $cat->countAllCatMenu([0, 0, 1, 0, 1]);
        
       $this->view->catMenu = $cat
          ->where('level>? AND visible= ?')->order_by("lft")->select()
          ->generator([0, 1]);
         
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

            //echo '<pre>';
           // print_r($this->view->newCat);
           //echo '</pre>';
           //exit;
 
        $this->view->page
            ->plusHeaderTitle($this->view->quote_ucfirst($this->view->newCat));
    }

     /////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    // public function checkcategoryAction(){
    //     if($_POST['category']){
    //         $post = trim( strip_tags( $_POST['category'] ));
    //         $cat = new Category();
    //         $category = $cat->getRowByField('name', $post);
    //         if($category){
    //             $this->view->category = $category;
    //         }else{
    //             $this->view->category = 'no';
    //         }
    //     }
        
    // }



/////////////////////////////////////////////////////////////////////
}
