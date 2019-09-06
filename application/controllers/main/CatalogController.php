<?php
namespace application\controllers\main;

use     engine\core\base\View, 
        application\models\Goods, 
        application\models\Category, 
        application\models\Company, 
        application\models\Address;
use  engine\core\App, engine\core\IController;        

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
            $cat = $this->checkOneParam('cat');
            $instCat = new Category();
            $this->view->catObj = $instCat->getObjById($cat); 
            if(!$this->view->catObj)
                    throw new \Exception("нет такой категории", 404);
            $this->view->brc = $instCat->getBrc($this->view->catObj);
            $this->view->listGoods = (new Goods())->getGoodsByCategory($cat);
            $this->view->counter = count($this->view->listGoods);
                        
            $this->view->componentLinkBRC = '/category/section/cat/';
            
            $this->view->page 
                ->plusTitle(' '.$this->view->catObj->name)
                ->plusHeaderTitle($this->view->quote_ucfirst( $this->view->catObj->name));
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

    public function companyCategoryAction()
    {
            $par = $this->checkParams(['cat', 'name'],['g']);
            $company = (int)$par["name"];
            $this->view->name = (new Company())->getTitleCompanyById($company);
                    if(!$this->view->name) throw new \Exception("Нет такой компании", 404);
            $cat = (int)$par["cat"];
            $instCat = new Category();

            $this->view->catObj = $instCat
                ->where('cat_id = ?')
                ->partObj([$cat], ['name', 'cat_id', 'parent_id', 'lft', 'rgt', 'level', 'ref']);

                if($this->view->catObj){
                    $this->view->brc = $instCat->getBrcAllCatalog($this->view->catObj, $company);
                }else throw new \Exception("Нет такой категории", 404);           
            $goods = new Goods();
            if(isset($par["g"])){ //один товар
                $g = (int)$par["g"];
                    if(empty($g)) throw new \Exception("g не число", 404);
                $this->view->goods = $goods->getGoodsByCompanyGoods($company, $g);
                    if($this->view->goods){
                        $this->view->listGoods = $goods->getGoodsCompanyByCatExGoods($company, $cat, $g);

                        //$this->view->title .= ' | '. $this->view->name->company. ' | ' . $this->view->goods->goods;
                       // $this->view->h1 = $this->view->goods->goods;
                        $this->view->page 
                            ->plusTitle(' | '. $this->view->name->company. ' | ' . $this->view->goods->goods)
                            ->plusHeaderTitle($this->view->goods->goods);
                        $this->file_view = 'goods_card_by_company';
                    } else 
                        throw new \Exception("Нет такого товара", 404);
            }else{//каталог товаров
                $this->view->listGoods = $goods->getGoodsByCompanyAndChildCat($company, $this->view->catObj->lft, $this->view->catObj->rgt);
                $this->view->page 
                    ->plusTitle($this->view->name->company. ' | ' . $this->view->catObj->name)
                    ->plusHeaderTitle($this->view->quote_ucfirst($this->view->catObj->name));
                $this->view->counter = count($this->view->listGoods);
                $this->file_view = 'goods_by_category_and_company';
            }
            $this->view->page
                ->setSubHeaderTitle('в организации '.$this->view->name->company_name);
           // $this->view->subh1 = ' в организации '.$this->view->name->company_name;
           //$this->view->title = $this->view->name->company. ' | ' . $this->view->catObj->name;
           // $this->view->h1 = 'Каталог '.$this->view->quote_ucfirst($this->view->catObj->name);
           
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
       
            $company = $this->checkOneParam('name');
                $this->view->name = (new Company())->getTitleCompanyById($company);
                    if(!$this->view->name){
                        throw new \Exception("нет такой компании", 404);   
                    }
                $this->view->listGoods = (new Goods())->getGoodsByCompany()
                                                        -> fetchAllClass([$company]);
                $this->view->counter = count($this->view->listGoods);
        
                $this->view->page 
                    ->plusTitle(' | '. $this->view->name->company.' | каталог')
                    ->plusHeaderTitle($this->view->name->company_name);
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
            $goods = $this->checkOneParam('g');
            $this->view->cardGoods = (new Goods())->getGoods($goods);
            if(!$this->view->cardGoods){
                throw new \Exception("нет такого товара", 404); 
            }
            $this->view->brc = (new Category())->getBrc($this->view->cardGoods);
            $this->view->listCompany = (new Company())->getCompaniesByGoods($goods);
            $this->view->componentLinkBRC = '/category/section/cat/';

            $this->view->page 
                    ->plusTitle(' | '.$this->view->cardGoods->name)
                    ->plusHeaderTitle($this->view->cardGoods->name);
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
            $place = $this->checkOneParam('p');
            $this->view->name = (new Address())->getPlaceById($place);
            if(!$this->view->name){
                throw new \Exception("нет такого place", 404); 
            }
            $this->view->listGoods = (new Goods())
                        ->getGoodsByPlace()
                        ->fetchAllClass([$place]);
            $this->view->counter = count($this->view->listGoods);

            $this->view->page 
                    ->plusTitle(' | '. $this->view->name->company.' | каталог')
                    ->plusHeaderTitle($this->view->name->company_name)
                    ->plusSubHeaderTitle($this->view->name->address.")");
    
    }   
/////////////////////////////////////////////////////////////////////

}