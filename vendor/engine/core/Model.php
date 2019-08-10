<?php
namespace vendor\engine\core;
use  vendor\engine\core\base\DB;

abstract class Model
{
    static public $table;
    protected $pk = 'id';
    public $attributes = [];
    public $errors = [];
    public $rules = [];

 /////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    // public function __construct(){
        
    // }

/////////////////////////////////////////////////////////////////////
    /**
     * для автоматической загрузки данных из формы
     */ 
    public function load($data) {
        foreach($this->attributes as $key => $v){
            if(isset($data[$key])){
                $this->attributes[$key] = $data[$key];
            }
        }
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
    public function validate($data) {
       // $v = new Validator($data);
       // $v->rules($this->rules);
       // if($v->validate()){
        //    return true;
       // }
        //$this->errors = $v->errors();
       // return false;


       return true;
       //return false;
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
    public function getErrors() {
        
     }
         
    
/////////////////////////////////////////////////////////////////////
    /**
     * 
     * используется напр. в Category.php ->getCategoryObj($id)
     * http://metrkv1/category/section/cat/88
     * вернет объект (класса, из которого вызвать; поля - из $fields) 
     * по значению ($id) поля с именес $pk
     */ 
    public function getObjById($id, $fields, $pk='') {
        $pk = $pk ?: $this->pk;
        $id = $this->clearInt($id);
            $sql  = "SELECT $fields
            FROM ".static::$table."
            WHERE $pk = ?";
    return $data = DB::prepare($sql)->execute([$id])->fetchObject(static::class);
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     * запись в таблице по полю в виде объекта
     */ 
    public function findOneObj($id, $field ='') {
        $field = $field ?: $this->pk;
            $sql  = "SELECT *
            FROM ".static::$table."
            WHERE $field = ?";
    return $data = DB::prepare($sql)->execute([$id])->fetchObject(static::class);
    }    
    

/////////////////////////////////////////////////////////////////////
    /**
     * 
     * запись в таблице по первичному ключу
     */ 
    public function findOne($id, $field ='') {
        $field = $field ?: $this->pk;
            $sql  = "SELECT *
            FROM ".static::$table."
            WHERE $field = ?
            LIMIT 1";
    return $data = DB::prepare($sql)->execute([$id])->fetch();
    }    
    
/////////////////////////////////////////////////////////////////////

    /**
     * 
     * используется напр. в goods->countGoodsByCat($id)
     */
    public function countRowIdByField($nameRowId, $nameField, $idField) {
        $idField = $this->clearInt($idField);
        $sql  = "SELECT
            COUNT($nameRowId)
            FROM ".static::$table."
            WHERE  $nameField = ?";
    return $data = DB::prepare($sql)->execute([$idField])->fetchColumn();
}
    
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
//жжжжжжжжжжжжжжжж     полезняшки     жжжжжжжжжжжжжжжжжжжжжжжжжжжжжжж/
/////////////////////////////////////////////////////////////////////

    
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function clearInt($query) {
        if((int)$query !== 0){
            return (int)$query;
        } else {
            echo 'должно быть число!';
        }
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function twoWordFromString($string) {
        $arr = explode(", ", $string);
        $slice = array_slice ($arr, 0, 2);
        return implode(", ",  $slice);
    }

// /////////////////////////////////////////////////////////////////////
//     /**
//      * 
//      */       
//     public static function ucfirst_utf8($str) {
//         return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr(mb_strtolower($str, 'utf-8'), 1, mb_strlen($str)-1, 'utf-8');
//     }

/////////////////////////////////////////////////////////////////////
//жжжжжжжжжжжжжжжж     oldDB     жжжжжжжжжжжжжжжжжжжжжжжжжжжжжжж/


//     public static function findAllClass() {
//         return self::$db->queryAllClass(
//             'SELECT *
//             FROM ' . static::TABLE,
//             static::class
//         );
//     }
    
//     public static function myfindAllClass($field, $join = null, $where = null) {
//         return self::$db->queryAllClass(
//             'SELECT '. $field .' 
//             FROM ' . static::TABLE.' '. $join .' '.$where,
//             static::class
//         );
//     }

    
//     public static function findAllStd(){
//         return self::$db->queryAllStd(
//             'SELECT *
//             FROM `'.static::TABLE.'` 
//             WHERE visible = 1'
//         );
//     }
    
//    public function findRowById($id) {
//         return self::$db->queryRowById(
//             'SELECT *
//             FROM  `'.static::TABLE.'`
//             WHERE id='.$id,
//             static::class
//         );
//     }
    
//     public function findCategory($id, $pid) {
//         return self::$db->queryAllStd(
//             "SELECT name, parent_id, id
//             FROM  `categories`
//             WHERE id IN ($id, $pid)
//             Order BY parent_id DESC",
//             static::class
//         );
//     }
    
//     public function findParentNameByParentId($id) {
//         return self::$db->query(
//             'SELECT name, id
//             FROM  `'.static::TABLE.'`
//             WHERE id ='.$id
//             );
//     }
    
//     public function findChildrenByParentId($parent_id) {
//         return self::$db->queryAllClass(
//             'SELECT *
//             FROM  `'.static::TABLE.'`
//             WHERE  visible = 1 AND parent_id='.$parent_id,
//             static::class
//         );
//     }
    
    
/////////////////////////////////////////////////////////////////////
}