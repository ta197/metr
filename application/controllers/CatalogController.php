<?php
namespace application\controllers;

use     application\models\View, application\models\Goods, 
        application\models\Category, application\models\CategoryMenu, 
        application\models\Company, application\models\Address;

class CatalogController  extends ParentController implements IController
{
    
/*все компании /все категории*/    
    public function indexAction()
    {
       /*Все товары всех компаний с лимитом, например, 30 товаров*/
    }


/* все компании /одна категория getGoodsCategory*/    
    public function categoryAction()
    {
        $fc = FrontController::getInstance();
        $cat = $fc->getParams()["cat"];
        //$view = new View();
        $this->view->catObj = (new Category())->getCategoryObj($cat);
            $m = new CategoryMenu();
        $this->view->brc = $m->getBrc($this->view->catObj);
        $this->view->listGoods = (new Goods())->getGoodsByCategory($cat);
        $output = $this->view->render(GOODS_BY_CATEGORY_FILE);
        $fc->setBody($output);

    }

/* одна компания / одна категория goodsCompanyByCat*/
    public function catcompanyAction()
    {
        $fc = FrontController::getInstance();
        //$view = new View();
        $company = $fc->getParams()["c"];
        $this->view->c = (new Company())->getTitleCompanyById($company);
        $cat = $fc->getParams()["cat"];
        if(!empty($fc->getParams()["g"])){
            $g = $fc->getParams()["g"];
        }
        
        $this->view->catObj = (new Category())->getCategoryObj($cat);
        $this->view->brc = (new CategoryMenu())->getBrcCatalog($this->view->catObj, $company);
        if(isset($g)){
            $this->view->goods = (new Goods())->getGoodsByCompanyGoods($company, $g);
            $this->view->listGoods = (new Goods())->getGoodsCompanyByCatExGoods($company, $cat, $g);
        }else{
            $this->view->listGoods = (new Goods())->getGoodsCompanyByCat($company, $cat);
        }
        $output = $this->view->render(GOODS_VIEW_FILE);
        $fc->setBody($output);
    }
    


/* одна компания / все категории*/
    public function companyAction()
    {
        $fc = FrontController::getInstance();
        $company = $fc->getParams()["c"];
        //$view = new View();
        $this->view->c = (new Company())->getTitleCompanyById($company);
        $this->view->listGoods = (new Goods())->getGoodsByCompany($company);
        $output = $this->view->render(GOODS_BY_COMPANY_FILE);
        $fc->setBody($output);
    }

/* одна компания / все категории*/
    public function goodsAction()
    {
        $fc = FrontController::getInstance();
        $goods = $fc->getParams()["g"];
        //$view = new View();
        $this->view->cardGoods = (new Goods())->getGoods($goods);
        $this->view->brc = (new CategoryMenu())->getBrc($this->view->cardGoods);
        $this->view->listCompany = (new Company())->getCompaniesByGoods($goods);
        $output = $this->view->render(GOODS_CARD_FILE);
        $fc->setBody($output);
    }

  
/* один адрес компании / весь каталог (все категории)*/
    public function placeAction()
    {
        $fc = FrontController::getInstance();
        $place = $fc->getParams()["p"];
        $this->view->c = (new Address())->getPlaceById($place);
        $this->view->listGoods = (new Goods())->getGoodsByPlace($place);
        $output = $this->view->render(GOODS_BY_PLACE_FILE);
        $fc->setBody($output);
    }   

}