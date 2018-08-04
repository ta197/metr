<?php
namespace application\models;
use application\base\Db;

abstract class Model
{
       
    protected static $db;

    public function __construct(){
    self::$db = Db::getInstance();
    }

    public static function findAllClass() {
        return self::$db->queryAllClass(
            'SELECT *
            FROM ' . static::TABLE,
            static::class
        );
    }
    
    public static function myfindAllClass($field, $join = null, $where = null) {
        return self::$db->queryAllClass(
            'SELECT '. $field .' 
            FROM ' . static::TABLE.' '. $join .' '.$where,
            static::class
        );
    }
   /*используется в Category.php*/ 
    public function getClassObjById($id, $fields, $pk) { //+
        return self::$db->queryClass(
            'SELECT '.$fields.'
            FROM `'.static::TABLE.'` 
            WHERE '.$pk.' = '.$id,
           static::class
        );
    }
    
    public static function findAllStd(){
        return self::$db->queryAllStd(
            'SELECT *
            FROM `'.static::TABLE.'` 
            WHERE visible = 1'
        );
    }
    
   public function findRowById($id) {
        return self::$db->queryRowById(
            'SELECT *
            FROM  `'.static::TABLE.'`
            WHERE id='.$id,
            static::class
        );
    }
    
    public function findCategory($id, $pid) {
        return self::$db->queryAllStd(
            "SELECT name, parent_id, id
            FROM  `categories`
            WHERE id IN ($id, $pid)
            Order BY parent_id DESC",
            static::class
        );
    }
    
    public function findParentNameByParentId($id) {
        return self::$db->query(
            'SELECT name, id
            FROM  `'.static::TABLE.'`
            WHERE id ='.$id
            );
    }
    
    public function findChildrenByParentId($parent_id) {
        return self::$db->queryAllClass(
            'SELECT *
            FROM  `'.static::TABLE.'`
            WHERE  visible = 1 AND parent_id='.$parent_id,
            static::class
        );
    }

    public function clearInt($query) {
        if((int)$query !== 0){
            return (int)$query;
        } else {
            echo 'должно быть число!';
        }
       
    }

    public function twoWordFromString($string) {
        $arr = explode(", ", $string);
        $slice = array_slice ($arr, 0, 2);
        return implode(", ",  $slice);
    }
        
    public static function ucfirst_utf8($str) {
        return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr(mb_strtolower($str, 'utf-8'), 1, mb_strlen($str)-1, 'utf-8');
    }

}