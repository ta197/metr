<?php
namespace application\models;

class CategoryMenu extends Model 
{
  // const TABLE = 'cats';
  // //public $db;
  // public $name;
  // public $cat_id;
  // public $parent_id;
  // public $visible;
  // public $ref;
  // public $lft;
  // public $rgt;
  // public $level;
  
  public function __construct(){
    parent::__construct();
  }

  // public function getBigCatMenu(){
  //    return self::$db->queryAll(
  //       "SELECT name, cat_id, level, activated FROM `cats` 
  //       WHERE level>0 AND visible = 1 
  //       ORDER BY lft");
  //       //SELECT  SQL_NO_CACHE name, id, level, disabled FROM `cats` WHERE level>0 AND visible=1 ORDER BY lft
  // }

  public function getQueryEachBigCatMenu(){
    return self::$db->queryEach(
       "SELECT name, cat_id, level, activated FROM `cats` 
       WHERE level>0 AND visible = 1 
       ORDER BY lft");
       //SELECT  SQL_NO_CACHE name, id, level, disabled FROM `cats` WHERE level>0 AND visible=1 ORDER BY lft
 }
 public function countAllCatMenu(){
  return self::$db->query(
     "SELECT COUNT(*) as countCat
     FROM `cats` 
     WHERE level>0 AND visible = 1 AND activated = 1");
}

  public function getBrc($obj){
    $arr_param[':lft'] = $this->clearInt($obj->lft);
    $arr_param[':rgt'] = $this->clearInt($obj->rgt);
    return self::$db->queryAll(
      "SELECT name, cat_id FROM `cats` 
      FORCE INDEX (`idx_keys`) 
      WHERE lft<:lft AND rgt>:rgt AND level>0 AND visible = 1
      ORDER BY lft", $arr_param);
  }

  public function getBrcCatalog(Category $cat, $cid){
    $arr_param[':lft'] = $this->clearInt($cat->lft);
    $arr_param[':rgt'] = $this->clearInt($cat->rgt);
    $arr_param[':cid'] = $this->clearInt($cid);
    return self::$db->queryAll(
      "SELECT cats.name AS name, cats.cat_id AS cat_id, cats.parent_id
      FROM `cats` 
      JOIN `places_cats` ON places_cats.cat_id = cats.cat_id
      JOIN `places_goods` ON places_cats.place_id = places_goods.place_id
      JOIN `places` ON places.place_id = places_goods.place_id
      WHERE lft<:lft AND rgt>:rgt AND level>0 AND visible = 1 AND places.company_id = :cid
      GROUP BY cats.name
      ORDER BY lft", $arr_param);
  }
  
  public function getCatMenu($cat){
    // $level = $cat->level;
    // $parent = $cat->parent_id;
    $lft = $cat->lft;
    $rgt = $cat->rgt;

    if(($rgt-$lft)>1){
      $arr_param[':lft'] = $lft;
      $arr_param[':rgt'] = $rgt;
        return self::$db->queryAll(
           "SELECT name, cat_id, parent_id, level, activated FROM `cats` 
           WHERE lft>:lft AND rgt<:rgt AND level>0 AND visible = 1
           ORDER BY lft", $arr_param);
    }
    else return null;
  }

}

  