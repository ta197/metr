<?php
namespace application\controllers;

use     application\models\View, 
        application\models\Goods, 
        application\models\Category, 
        application\models\Company, 
        application\models\Address;

class CatalogController  extends ParentController implements IController
{


 /////////////////////////////////////////////////////////////////////   
/**
 * 
 * все компании /все категории
 */   
    public function indexAction()
    {
       /*Все товары всех компаний с лимитом, например, 30 товаров*/
    }

/////////////////////////////////////////////////////////////////////
/**
 * 
 * пример http://metrkv1/catalog/category/cat/91
 * все компании /одна категория getGoodsCategory
 * 
 */    
    public function categoryAction()
    {
        $cat = $this->fc->getParams()["cat"];
        $instCat = new Category();
        $this->view->catObj = $instCat->getCategoryObj($cat);
        $this->view->brc = $instCat->getBrc($this->view->catObj);
        $this->view->listGoods = (new Goods())->getGoodsByCategory($cat);
        $this->view->counter = count($this->view->listGoods);

        $this->view->navStatus = $this->view->navStatus(['metr'], 'CategoryActiv');
        $this->view->title =  $this->view->catObj->name.' | каталог';
        $this->view->h1 = 'Каталог категории '.$this->view->quote_ucfirst( $this->view->catObj->name);
        $this->view->componentLinkBRC = '/category/section/cat/'; 
    }


/////////////////////////////////////////////////////////////////////
/**
 * 
 * http://metrkv1/catalog/catcompany/name/9/cat/16
 * http://metrkv1/catalog/catcompany/name/15/cat/12/g/9
 * одна компания / одна категория goodsCompanyByCat
 */

    public function catcompanyAction()
    {
        $company = $this->fc->getParams()["name"];
        $this->view->name = (new Company())->getTitleCompanyById($company);
        $cat = $this->fc->getParams()["cat"];
        if(!empty($this->fc->getParams()["g"])){
            $g = $this->fc->getParams()["g"];
        }
        $instCat = new Category();
        $this->view->catObj = $instCat->getCategoryObj($cat);
        $this->view->brc = $instCat->getBrcAllCatalog($this->view->catObj, $company);
        $goods = new Goods();
        if(isset($g)){//один товар
            $this->view->goods = $goods->getGoodsByCompanyGoods($company, $g);
            $this->view->listGoods = $goods->getGoodsCompanyByCatExGoods($company, $cat, $g);
            $this->view->title = $this->view->name->company. ' | ' . $this->view->goods->goods;
            $this->view->h1 = $this->view->goods->goods;

            $this->file_view = 'goods_card_by_company';
           
        }else{//каталог товаров
            $this->view->listGoods = $goods->getGoodsByCompanyAndChildCat($company, $this->view->catObj->lft, $this->view->catObj->rgt);
            $this->view->title = $this->view->name->company. ' | ' . $this->view->catObj->name;
            $this->view->h1 = 'Каталог '.$this->view->quote_ucfirst($this->view->catObj->name);
            $this->view->counter = count($this->view->listGoods);
            
            $this->file_view = 'goods_by_category_and_company';
        }
        $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv');
        $this->view->subh1 = ' в организации '.$this->view->name->company_name;
    }


/////////////////////////////////////////////////////////////////////    
/**
 * 
 *  http://metrkv1/catalog/company/name/2
 *  одна компания / все категории
 */
    public function companyAction()
    {
        $company = $this->fc->getParams()["name"];
        $this->view->name = (new Company())->getTitleCompanyById($company);
        $this->view->listGoods = (new Goods())->getGoodsByCompany($company);
        $this->view->counter = count($this->view->listGoods);

        $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv');
        $this->view->title = $this->view->name->company.' | каталог';
        $this->view->h1 = 'Каталог организации '.$this->view->name->company_name;
    }

/////////////////////////////////////////////////////////////////////
/**
 * 
 * http://metrkv1/catalog/goods/g/6
 * одна компания / все категории
 */
    public function goodsAction()
    {
        $goods = $this->fc->getParams()["g"];
        $this->view->cardGoods = (new Goods())->getGoods($goods);
        $this->view->brc = (new Category())->getBrc($this->view->cardGoods);
        $this->view->listCompany = (new Company())->getCompaniesByGoods($goods);
        //$this->view->componentLinkBRC = '/category/section/cat/';

        $this->view->navStatus = $this->view->navStatus(['metr'], 'CategoryActiv');
        $this->view->title = $this->view->h1 = $this->view->cardGoods->name;
    }

/////////////////////////////////////////////////////////////////////  
/**
 * 
 * http://metrkv1/catalog/place/p/13
 *  один адрес компании / весь каталог (все категории)
 */
    public function placeAction()
    {
        $place = $this->fc->getParams()["p"];
        $this->view->name = (new Address())->getPlaceById($place);
        $this->view->listGoods = (new Goods())->getGoodsByPlace($place);
        $this->view->counter = count($this->view->listGoods);

        $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv');
        $this->view->title = $this->view->name->company.' | каталог';
        $this->view->h1 = 'Каталог организации '.$this->view->name->company_name;
        $this->view->subh1 =' (адрес: '.$this->view->name->address.')';
    }   
/////////////////////////////////////////////////////////////////////

}