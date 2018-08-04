<?php
namespace application\controllers;

use application\models\View, application\models\CategoryMenu, application\models\Category, application\models\Company;

class CategoryController extends ParentController implements IController
{
  
  public function indexAction()
  {
    $fc = FrontController::getInstance();
        $catMenu = new CategoryMenu();
    $this->view->countCatMenu = $catMenu->countAllCatMenu();
    $this->view->catMenu = $catMenu->getQueryEachBigCatMenu();
    $this->view->navStatus = $this->view->navStatus('CategoryActiv', 'CategoryDisabled');
    $output = $this->view->render(DEFAULT_CATEGORY_FILE);
    $fc->setBody($output);
  }

  public function sectionAction()
  {
    $fc = FrontController::getInstance();
    $id = $fc->getParams()["cat"];
    //$this->view->navStatus = $this->view->navStatus('CategoryActiv');
        $category = new Category();
    $this->view->cat = $category->getCatObj($id);
    $this->view->cat->countGoods = $category->countGoodsByCat($id);
        $m = new CategoryMenu();
    $this->view->catMenu = $m->getCatMenu($this->view->cat);
    $this->view->brc = $m->getBrc($this->view->cat);
        $company =new Company();
    $this->view->countCompany = $company->countCompaniesByCategory($id);
    $this->view->listCompany = $company->getCompaniesByCategory($id);

    $output = $this->view->render(CATEGORY_VIEW_FILE);
    $fc->setBody($output);
  }

}