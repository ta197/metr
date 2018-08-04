<?php
namespace application\models;

class Category extends Model {
    const TABLE = 'cats';
    //public $db;
    public $name;
    public $cat_id;
    public $parent_id;
    public $visible;
    public $ref;
    public $lft;
    public $rgt;
    public $level;
    public $countGoods = null;
       
    public function __construct(){
      parent::__construct();
    }
    
    public function getCategoryObj($id){
      $pk = 'cat_id';
      $fields = "name, $pk, parent_id, lft, rgt, level, ref";
      return $this->getClassObjById($id, $fields, $pk);
    }

    public function getCatObj($id){
      $id = $this->clearInt($id);
      return self::$db->queryClass(
        "SELECT
        cats.name, cats.cat_id, cats.parent_id, cats.lft, cats.rgt, cats.level, cats.ref 
        FROM `cats`
        WHERE cats.cat_id = $id", 
        self::class
      );
    }

    public function countGoodsByCat($id){
      $arr[] = $this->clearInt($id);
      $cG = self::$db->query(
        "SELECT
        COUNT(goods.goods_id) as countGoods
        FROM `goods`
        WHERE  goods.cat_id = ?",
        $arr);
        return $cG['countGoods'];
    }
}

?>