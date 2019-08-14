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

class CatalogController extends ParentAdminController implements IController
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

        $this->view->navStatus = $this->view->navStatus(['admin'], 'CatalogActiv', 'CatalogDisabled');
        $this->view->title = 'каталог';
        $this->view->h1 = 'Каталог';
    }


  

/////////////////////////////////////////////////////////////////////
}
