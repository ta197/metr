<?php
namespace application\models;
use  engine\core\db\DB, engine\core\ToString;

class Category extends ToString 
{
  static public $pk = 'cat_id';
  static public $table = 'cats';
  static public $sql;

  public $name;
  public $cat_id;
  public $parent_id;
  public $visible;
  public $ref;
  public $lft;
  public $rgt;
  public $level;
  public $countGoods = null;

  static public $page_link = [
    'one' => 'category/section/cat/',
    'list_full' => 'category',
    'list_alphabet' => 'company/alphabet/letter/',
  ];

  static public $string = ['name'];
 
    
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    //public function __construct(){
     
   // }

    
/////////////////////////////////////////////////////////////////////
     /**
     * 
     */   
    public function getCategoryObj($id){
      //$nameId = 'cat_id';
      $fields = "name, ". static::$pk .", parent_id, lft, rgt, level, ref";
      return $this->getObjById($id, $fields);
    }
    
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
  //   public function getBigCatMenu($fields = 'visible'){
  //     switch ($fields):
  //      case 'visible': 
  //        $fields = "name, cat_id, level, activated, parent_id, lft, rgt "; 
  //        $vis = [1, 2]; break;
  //      case 'full': 
  //        $fields = "name, cat_id, level, activated, visible, lft, rgt"; 
  //        $vis = [0, 1]; break;
  //      default: 
  //        $fields = "name, cat_id, level"; 
  //        $vis = [1, 2]; break;
  //     endswitch;
  //    $sql = "SELECT $fields FROM `cats` 
  //       WHERE level>0 AND visible IN (?, ?) 
  //       ORDER BY lft";
  //      $data = DB::prepare($sql)->execute($vis);
  //      if(false !== $data){
  //        while ($row = $data->fetch()){
  //         yield $row;
  //        }
  //      }
  //  }

     
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function getCatMenuIncLevelZero(){
  
     $sql = "SELECT name, cat_id, level, rgt FROM `cats`
        ORDER BY lft";
       $data = DB::prepare($sql)->execute();
       if(false !== $data){
         while ($row = $data->fetch()){
          yield $row;
         }
       }
   }  
   
    
/////////////////////////////////////////////////////////////////////
     /**
     * 
     */  
     public function countAllCatMenu($p = [0, 1, 2, 1, 2]){
       $sql = "SELECT COUNT(cats.cat_id)
         FROM `cats` 
         WHERE level>? AND visible IN (?, ?) AND activated IN (?, ?)";
       return $count = DB::prepare($sql)->execute($p)->fetchColumn();  
     }

 ///////////////////////////////////////////////////////////////////// 
    /**
     * 
     */   
     public function getBrc($obj){
       $arr_param[':lft'] = $this->clearInt($obj->lft);
       $arr_param[':rgt'] = $this->clearInt($obj->rgt);
     
         $sql  = "SELECT name, cat_id FROM `cats` 
         WHERE lft<:lft AND rgt>:rgt AND level>0 AND visible = 1
         ORDER BY lft";
         return $data = DB::prepare($sql)->execute($arr_param)->fetchAll();
     }


///////////////////////////////////////////////////////////////////// 
    /**
     * аналог getBrcAllCatalog
     * главная | организации | «Новосел», магазин | каталог | обои // отказалась пока от такого в пользу getBrcAllCatalog
     * 
     * не отображает тех категорий, в которых (непосредственно в них) нет товара
     * исходит из логики: там товара нет - нечего и давать ссылку на нее
     */     
    //  public function getBrcCatalog(Category $cat, $cid){
    //    $arr_param[':lft'] = $this->clearInt($cat->lft);
    //    $arr_param[':rgt'] = $this->clearInt($cat->rgt);
    //    $arr_param[':cid'] = $this->clearInt($cid);
    //      $sql  = "SELECT cats.name AS name, cats.cat_id AS cat_id, cats.parent_id
    //      FROM `cats` 
    //      JOIN `places_cats` ON places_cats.cat_id = cats.cat_id
    //      JOIN `places_goods` ON places_cats.place_id = places_goods.place_id
    //      JOIN `places` ON places.place_id = places_goods.place_id
    //      WHERE lft<:lft AND rgt>:rgt AND level>0 AND visible = 1 AND places.company_id = :cid
    //      GROUP BY cats.name
    //      ORDER BY lft";
    //     return $data = DB::prepare($sql)->execute($arr_param)->fetchAll();
    //  }

    /**
     * аналог getBrcCatalog ()
     * главная | организации | «Новосел», магазин | каталог | материалы для чистовой отделки | обои
     * 
     * отображает те категории, в которых (непосредственно в них) нет товара
     * исходит из логики: там товар есть уже потому, что он есть у потомков
     * не проверена
     */     
    public function getBrcAllCatalog(Category $cat, $cid){
      $arr_param[':lft'] = $this->clearInt($cat->lft);
       $arr_param[':rgt'] = $this->clearInt($cat->rgt);
       $arr_param[':cid'] = $this->clearInt($cid);
      $sql  = "SELECT name, cat_id FROM `cats`
        JOIN `places` ON places.company_id = :cid
        WHERE lft<:lft AND rgt>:rgt AND level>0 AND visible = 1 
        GROUP BY cats.name
        ORDER BY lft";
      return $data = DB::prepare($sql)->execute($arr_param)->fetchAll();
    }
    
///////////////////////////////////////////////////////////////////// 
    /**
     * 
     */    
     public function getCatMenu($cat){
       $lft = $cat->lft;
       $rgt = $cat->rgt;
       if(($rgt-$lft)>1){
         $arr_param[':lft'] = $lft;
         $arr_param[':rgt'] = $rgt;
         $sql  = "SELECT name, cat_id, parent_id, level, activated FROM `cats` 
              WHERE lft>:lft AND rgt<:rgt AND level>0 AND visible = 1
              ORDER BY lft";
           return $data = DB::prepare($sql)->execute($arr_param)->fetchAll();   
       }
       else return false;
     }
   
 /////////////////////////////////////////////////////////////////////////////////
    /**
     * 
     * сколько штук подменю у категории (для меню на странице категории)
     */   
     public function countCatSubMenu($catMenu, $cat){
       $countCatSubMenu = 0;
       if(empty($catMenu)) return $countCatSubMenu;
         foreach($catMenu as $k=>$v){
             if($v['level']==($cat->level)+1) $countCatSubMenu++;
         }
         return $countCatSubMenu;
     }
   
   
/////////////////////////////////////////////////////////////////////////////////
   
/////////////////////////////////////////////////////////////////////////////////
    /**
     * 
     * создание новой категории и добавление ее в дерево
     */   
    public function createCategory($name, Category $parentObj = null, $activated, $visible){
      $params = parse_ini_file ('config.ini');
      $DB = $params['db.name'];
      
      if(!$parentObj){
        $max_rgt = 20000;
        $parent_rgt = $max_rgt+1;
        $parent_level = 0;
      }else {
        $parent_rgt = $parentObj->rgt;
        $parent_level = $parentObj->level;
      }
//UPDATE
//INSERT

//return  $idNewObj;
      return  $parent_rgt;
      
    }
  
    
 /////////////////////////////////////////////////////////////////////////////////
}
