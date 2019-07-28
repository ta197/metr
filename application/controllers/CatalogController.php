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
 * http://metrkv1/catalog
 * все компании /все категории
 * Все товары всех компаний с лимитом, например, 30 товаров
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
 * параметр cat (обязательный)
 * 
 */    
    public function categoryAction()
    {
        try{
            $cat = $this->checkOneParam('cat');
            $instCat = new Category();
            $this->view->catObj = $instCat->getCategoryObj($cat); 
            if(!$this->view->catObj)
                    throw new AppException("нет такой категории");
            $this->view->brc = $instCat->getBrc($this->view->catObj);
            $this->view->listGoods = (new Goods())->getGoodsByCategory($cat);
            $this->view->counter = count($this->view->listGoods);
            $this->view->navStatus = $this->view->navStatus(['metr'], 'CategoryActiv');
            $this->view->title =  $this->view->catObj->name.' | каталог';
            $this->view->h1 = 'Каталог категории '.$this->view->quote_ucfirst( $this->view->catObj->name);
            $this->view->componentLinkBRC = '/category/section/cat/';
        }catch(AppException $e){
            $e->err404($e, $this->fc->route);
        }
    }


/////////////////////////////////////////////////////////////////////
/**
 * 
 * http://metrkv1/catalog/catcompany/name/9/cat/16
 * http://metrkv1/catalog/catcompany/name/15/cat/12/g/9
 * одна компания / одна категория goodsCompanyByCat
 * 
 * параметры name, cat (обязательные)
 * параметр g (необязательный)
 */

    public function catcompanyAction()
    {
        try{
            $par = $this->checkParams(['cat', 'name'],['g']);
            $company = (int)$par["name"];
            $this->view->name = (new Company())->getTitleCompanyById($company);
                    if(!$this->view->name) throw new AppException("Нет такой компании");
            $cat = (int)$par["cat"];
            $instCat = new Category();
            $this->view->catObj = $instCat->getCategoryObj($cat);
                if($this->view->catObj){
                    $this->view->brc = $instCat->getBrcAllCatalog($this->view->catObj, $company);
                }else throw new AppException("Нет такой категории");           
            $goods = new Goods();
            if(isset($par["g"])){ //один товар
                $g = (int)$par["g"];
                    if(empty ($g)) throw new AppException("g не число");
                $this->view->goods = $goods->getGoodsByCompanyGoods($company, $g);
                    if($this->view->goods){
                        $this->view->listGoods = $goods->getGoodsCompanyByCatExGoods($company, $cat, $g);
                        $this->view->title = $this->view->name->company. ' | ' . $this->view->goods->goods;
                        $this->view->h1 = $this->view->goods->goods;
                        $this->file_view = 'goods_card_by_company';
                    } else throw new AppException("Нет такого товара");
            }else{//каталог товаров
                $this->view->listGoods = $goods->getGoodsByCompanyAndChildCat($company, $this->view->catObj->lft, $this->view->catObj->rgt);
                $this->view->title = $this->view->name->company. ' | ' . $this->view->catObj->name;
                $this->view->h1 = 'Каталог '.$this->view->quote_ucfirst($this->view->catObj->name);
                $this->view->counter = count($this->view->listGoods);
                $this->file_view = 'goods_by_category_and_company';
            }
            $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv');
            $this->view->subh1 = ' в организации '.$this->view->name->company_name;
        }catch(AppException $e){
            $e->err404($e, $this->fc->route);
        }
    }


/////////////////////////////////////////////////////////////////////    
/**
 * 
 *  http://metrkv1/catalog/company/name/2
 *  одна компания / все категории
 *  параметр name (обязательный)
 */
    public function companyAction()
    {
        try{
            $company = $this->checkOneParam('name');
                $this->view->name = (new Company())->getTitleCompanyById($company);
                    if(!$this->view->name){
                        throw new AppException("нет такой компании");   
                    }
                $this->view->listGoods = (new Goods())->getGoodsByCompany($company);
                $this->view->counter = count($this->view->listGoods);
        
                $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv');
                $this->view->title = $this->view->name->company.' | каталог';
                $this->view->h1 = 'Каталог организации '.$this->view->name->company_name;    

        }catch(AppException $e){
            $e->err404($e, $this->fc->route);
        }
    }

/////////////////////////////////////////////////////////////////////
/**
 * 
 * http://metrkv1/catalog/goods/g/6
 * одна компания / все категории
 * параметр g (обязательный)
 */
    public function goodsAction()
    {
        try{
            $goods = $this->checkOneParam('g');
            $this->view->cardGoods = (new Goods())->getGoods($goods);
            if(!$this->view->cardGoods){
                throw new AppException("нет такого товара"); 
            }
            $this->view->brc = (new Category())->getBrc($this->view->cardGoods);
            $this->view->listCompany = (new Company())->getCompaniesByGoods($goods);
            $this->view->componentLinkBRC = '/category/section/cat/';
        
            $this->view->navStatus = $this->view->navStatus(['metr'], 'CategoryActiv');
            $this->view->title = $this->view->h1 = $this->view->cardGoods->name;
        }catch(AppException $e){
            $e->err404($e, $this->fc->route);
        }
    }

/////////////////////////////////////////////////////////////////////  
/**
 * 
 * http://metrkv1/catalog/place/p/13
 *  один адрес компании / весь каталог (все категории)
 * параметр p (обязательный)
 */
    public function placeAction()
    {
        try{
            $place = $this->checkOneParam('p');
            $this->view->name = (new Address())->getPlaceById($place);
            if(!$this->view->name){
                throw new AppException("нет такого place"); 
            }
            $this->view->listGoods = (new Goods())->getGoodsByPlace($place);
            $this->view->counter = count($this->view->listGoods);
            $this->view->navStatus = $this->view->navStatus(['metr'], 'CompanyActiv');
            $this->view->title = $this->view->name->company.' | каталог';
            $this->view->h1 = 'Каталог организации '.$this->view->name->company_name;
            $this->view->subh1 =' (адрес: '.$this->view->name->address.')';
        }catch(AppException $e){
            $e->err404($e, $this->fc->route);
        }
    }   
/////////////////////////////////////////////////////////////////////

}