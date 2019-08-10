<?php
namespace application\controllers\main;

use 
    application\models\View, 
    application\models\Category,
    application\models\Company, 
    application\models\Goods;
use  vendor\engine\core\App,   vendor\engine\core\IController;
    
class CategoryController extends ParentController implements IController
{
  
  public function indexAction()
  {
    $catMenu = new Category();
    //$count = App::$app->cache->get('count');
    //if(!$count){
      $this->view->counter = $catMenu->countAllCatMenu();
     // App::$app->cache->set('count', $this->view->counter);
    //}
    
    $this->view->catMenu = $catMenu->getBigCatMenu();

    $this->view->navStatus = $this->view->navStatus(['metr'], 'CategoryActiv', 'CategoryDisabled');
    $this->view->title = 'категории';
    $this->view->h1 = 'Все категории';

  }


/////////////////////////////////////////////////////////////////////  
/**
 * 
 * http://metrkv1/category/section/cat/91
 * параметр cat (обязательный)
 */
  public function sectionAction()
  {
   // try{
      $id = $this->checkOneParam('cat');
      $instCat = new Category();
      $this->view->cat = $instCat->getCategoryObj($id);
      if(!$this->view->cat)
          throw new \Exception("нет такой категории", 404);
      $this->view->catMenu = $instCat->getCatMenu($this->view->cat);
      $this->view->cat->countGoods = (new Goods())->countGoodsByCat($id);
      $this->view->countCatSubMenu = $instCat->countCatSubMenu($this->view->catMenu, $this->view->cat); 
      $this->view->brc = $instCat->getBrc($this->view->cat);
      $company = new Company();
      $this->view->counter = $company->countCompaniesByCategory($id);
      $this->view->listCompany = $company->getCompaniesByCategoryAndGoods($id);

      $this->view->navStatus = $this->view->navStatus(['metr'], 'CategoryActiv');
      $this->view->title =  $this->view->cat->name;
      $this->view->h1 =  $this->view->cat->name;
    //}catch(AppException $e){
      //$e->err404($e, $this->fc);
    //}
  }
/////////////////////////////////////////////////////////////////////

}