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
    $this->view->title = 'категории';
    $this->view->h1 = 'Все категории';
        $catMenu = new Category();
    $this->view->counter = $catMenu->countAllCatMenu();
    $this->view->catMenu = $catMenu->getBigCatMenu();
    $this->view->navStatus = $this->view->navStatus(['metr'], 'CategoryActiv', 'CategoryDisabled');
    $output = $this->view->render(DEFAULT_CATEGORY_FILE);
    $this->fc->setBody($output);
  }


/////////////////////////////////////////////////////////////////////  
/**
 * 
 * http://metrkv1/category/section/cat/91
 * 
 */
  public function sectionAction()
  {
    $id = $this->fc->getParams()["cat"];
    
    $instCat = new Category();
    $this->view->cat = $instCat->getCategoryObj($id);
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
    $output = $this->view->render(CATEGORY_VIEW_FILE);
    $this->fc->setBody($output);
  }
/////////////////////////////////////////////////////////////////////

}