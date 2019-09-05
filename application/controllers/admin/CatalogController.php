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

class CatalogController extends ParentAdminController implements IController
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
               $createCat = $cat->where('name = ?')->select()->fetchObject([$post]);
               //var_dump($createCat); die;
                if($createCat){
                    $this->view->createCat = $createCat;
                    $this->view->quote_query = $createCat->name;
                }else{
                    $this->view->createCat = false;
                    //header("Location: http://{$_SERVER['HTTP_HOST']}/admin/category/create/name/$post");
                    $this->redirect("http://{$_SERVER['HTTP_HOST']}/admin/category/create/name/$post");
                    exit;
                }
            }
        }
        $this->view->counter = $cat->countAllCatMenu([0, 0, 1, 0, 1]);
        //$this->view->catMenu = $cat->getBigCatMenu('full');
        $this->view->catMenu = $cat
            ->where('level>? AND visible= ?')->order_by("lft")->select()->generator([0, 1]);
    }


  

/////////////////////////////////////////////////////////////////////
}
