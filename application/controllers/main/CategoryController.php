<?php
namespace application\controllers\main;

use 
    engine\core\base\View,
    engine\core\base\Controller, 
    application\models\Category,
    application\models\Company, 
    application\models\Goods;
use  engine\core\IController, engine\core\Page, engine\core\Menu;
    
class CategoryController extends ParentController implements IController
{
  
/////////////////////////////////////////////////////////////////////   
  public function indexAction()
  {
    $catMenu = new Category();
    //$count = App::$app->cache->get('count');
    //if(!$count){
      $this->view->counter = $catMenu->countAllCatMenu();
     // App::$app->cache->set('count', $this->view->counter);
    //}
    
    $this->view->catMenu = $catMenu
      ->fields(['name', 'cat_id', 'level', 'activated', 'parent_id', 'lft', 'rgt'])
      ->where('level>? AND visible= ?')->order_by("lft")->select()->generator([0, 1]);

    //$this->b($this->view->nav, 1);
  }


/////////////////////////////////////////////////////////////////////  
/**
 * 
 * http://metrkv1/category/section/cat/91
 * параметр cat (обязательный)
 */
  public function sectionAction()
  {
    $par = $this->checkParams(['cat'], ['sub']);
    $id = (int)$par["cat"];
      $instCat = new Category();
      $this->view->cat = $instCat->getObjById($id);
      if(!$this->view->cat)
          throw new \Exception("нет такой категории", 404);
      $this->view->catMenu = $instCat->getCatMenu($this->view->cat);
    
      $this->view->cat->countGoods = (new Goods())->where('cat_id = ?')->count('goods_id')->fetchColumn([$id]);
     
      $this->view->countCatSubMenu = $instCat->countCatSubMenu($this->view->catMenu, $this->view->cat); 
      $this->view->brc = $instCat->getBrc($this->view->cat);
      $company = new Company();
      $this->view->counter = $company->countCompaniesByCategory()->fetchColumn([$id]) ;
      $this->view->listCompany = $company->getCompaniesByCategoryAndGoods()->generator([$id]);
      
      $this->view->page
          ->plusTitle(' | '.$this->view->cat->name)
          ->setHeaderTitle($this->view->cat->name);

  }
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}