<?php
namespace application\controllers;

use 
    application\models\View, 
    application\models\Category,
    application\models\Company, 
    application\models\Goods;

class CategoryController extends ParentController implements IController
{
  
  public function indexAction()
  {
    $catMenu = new Category();
    $this->view->counter = $catMenu->countAllCatMenu();
    $this->view->catMenu = $catMenu->getBigCatMenu();
    
    $this->view->navStatus = $this->view->navStatus(['metr'], 'CategoryActiv', 'CategoryDisabled');
    $this->view->title = 'категории';
    $this->view->h1 = 'Все категории';
  }


/////////////////////////////////////////////////////////////////////  
/**
 * 
 * http://metrkv1/category/section/cat/91
 * 
 */
  public function sectionAction()
  {
    try{
      if(isset($this->fc->getParams()["cat"])){
        $id = $this->fc->getParams()["cat"];
        $id = (int)$id;
        if(empty ($id))
            throw new AppException("cat name !num");
      }else{
        throw new AppException("cat !name");
      }
      $instCat = new Category();
      $this->view->cat = $instCat->getCategoryObj($id);
      if($this->view->cat){
        $this->view->title =  $this->view->cat->name;
        $this->view->h1 =  $this->view->cat->name;

        $this->view->catMenu = $instCat->getCatMenu($this->view->cat);

        $this->view->cat->countGoods = (new Goods())->countGoodsByCat($id);
        $this->view->countCatSubMenu = $instCat->countCatSubMenu($this->view->catMenu, $this->view->cat); 
        $this->view->brc = $instCat->getBrc($this->view->cat);
          $company = new Company();
          $this->view->counter = $company->countCompaniesByCategory($id);
          $this->view->listCompany = $company->getCompaniesByCategoryAndGoods($id);

        $this->view->navStatus = $this->view->navStatus(['metr'], 'CategoryActiv');
      }else{
        throw new AppException("!cat");
      }
    }catch(AppException $e){
      $e->err404($e, $this->fc->route);
    }
  }
/////////////////////////////////////////////////////////////////////

}