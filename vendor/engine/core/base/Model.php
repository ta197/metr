<?php
namespace engine\core\base;
use engine\core\db\DB;
use Valitron\Validator;

class Model
{
    static public $table;
    static public $pk = 'id';
    static public $sql;         // sql-запрос
    //static public $class = 'stdClass'; 
    static public $coreProps = [];

    protected $attributes = [];
    public $errors = [];
    protected $rules = [];

    protected $fields = '*';         // какие поля тащить

    protected $query = array(
        'table' => '',       // имя таблицы
        'join' => '',        // с чем объединять
        'left_join' => '',   // с чем объединять
        'right_join' => '',  // с чем объединять
        'where' => '',       // что брать, что не брать
        'group_by' => '',    // с кем группировать 
        'having' => '',      // что брать, что не брать после группировки 
        'order_by' => '',     // как отсортировать
        'limit' => ''     
    );

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function __construct(){
        if(static::$table){
            $this->query['table'] = static::$table;
        }
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function generator($param = [])
    {
        $data = DB::prepare(static::$sql)->execute($param);
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
    public function fetch($param = [])
    {
        return $data = DB::prepare(static::$sql)->execute($param)->fetch();
    }    

///////////////////////////////////////////////////////////////////// 
    /**
     * 
     */  
    public function fetchAll($param = [])
    {
        return $data = DB::prepare(static::$sql)
                ->execute($param)->fetchAll();
    }

///////////////////////////////////////////////////////////////////// 
    /**
     * 
     */  
    public function fetchAllClass($param = [])
    {
        return $data = DB::prepare(static::$sql)
                ->execute($param)
                ->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

///////////////////////////////////////////////////////////////////// 

    /**
     * 
     */  
    public function fetchAllGroup($param = [])
    {
        return $data = DB::prepare(static::$sql)
                ->execute($param)
                ->fetchAll(\PDO::FETCH_COLUMN|\PDO::FETCH_GROUP, static::class);
    }

///////////////////////////////////////////////////////////////////// 

///////////////////////////////////////////////////////////////////// 
    /**
     * 
     * используется напр. в goods->countGoodsByCat($id)
     */
    public function fetchColumn($param = []) 
    {
        return $data = DB::prepare(static::$sql)
                ->execute($param)
                ->fetchColumn();
    }
    
/////////////////////////////////////////////////////////////////////
 
/////////////////////////////////////////////////////////////////////       
    /**
     * 
     */ 
    public function fetchObject($param = []) 
    {
        return $data = DB::prepare(static::$sql)
                    ->execute($param)
                    ->fetchObject(static::class);
    }

/////////////////////////////////////////////////////////////////////
    /**
     * частный случай getObject
     * вызывается с уже прописанным where 
     * 
     * используется напр. в Category.php ->getCategoryObj($id)
     * http://metrkv1/category/section/cat/88
     * 
     */ 
    public function getObjById($id) 
    {
        $this->id();
        $this->where(static::$pk." = ?");
        $this->select();
        return $data = DB::prepare(static::$sql)
                        ->execute([$id])
                        ->fetchObject(static::class);
    }

/////////////////////////////////////////////////////////////////////         
    /**
     * 
     *  например $catObj = $instCat->where('cat_id = ?')->part([$cat], 'name, cat_id, parent_id');
     *  
     */ 
    public function partObj($param, $fields = null) 
    {
        $this->fields($fields);
        $this->select();    
        return $data = DB::prepare(static::$sql)
                        ->execute($param)
                        ->fetchObject(static::class);
    }

/////////////////////////////////////////////////////////////////////
    /**
     * частный случай fetchAll
     *  например $catObj = $instCat->where('cat_id = ?')->part([$cat], 'name, cat_id, parent_id');
     *  
     */ 
    public function partAll($fields = null) 
    {
        $this->fields($fields)->id()->order_by_id('DESC');
        $this->select();    
        return $data = DB::prepare(static::$sql)
                        ->execute()
                        ->fetchAll();
    }
    
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * формирует поля для выборки из БД
     * 1) либо указаны
     * 2) либо берутся из static::$coreProps
     * 3) либо по умолчанию - все
     *  
     */ 
    public function fields($fields = null, $pk_as = null) 
    {
        if($fields == null){
            if(!empty(static::$coreProps)){
                $this->fields = implode(', ', static::$coreProps); 
            }else{
                $this->fields = '';
            }
        }elseif($fields){
            $this->fields = implode(', ', $fields);
        }else{
            $this->fields = '';
        }

        if(!empty($pk_as)){
            $this->fields .= $this->alias_pk($pk_as);
        }
        return $this;
    }

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     * добавляет к перечню полей поле алиас поля первичного ключа
     * если таблца была задана типа 'as c', то это 'c' конкатенир. через точку: 
     * например, c.company_id as 'primary_key'
     * используется в виджете поиска
     */ 
    protected function alias_pk($pk_as)
    {
        $this->id();
        $alias_id = static::$pk;
        if(strpos($this->query["table"], ' AS ')){
            $alias_id = static::$table[0].'.'.$alias_id;
        }
        return ", $alias_id AS `$pk_as` ";
    }

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * 
     * генерация запроса на количество записей в таблице
     */
    public function count($field) 
    {
        static::$sql = "SELECT
                        COUNT($field)
                        FROM {$this->concatenation()}";
        return $this;
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     * Генерация Select-запроса к БД
     */ 
    public function select()
    {
        static::$sql = "SELECT {$this->fields} 
                        FROM {$this->concatenation()}";
        return $this;   
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     * Конкатенация строки запроса к БД
     */ 
    private function concatenation()
    {
        return implode(' ', $this->query);  
    }

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     * 
     * Дописать к Select-запросу, например лимит
     */ 
    public function inEnd($end)
    {
        if($this->query[$end])
            static::$sql = static::$sql .' '. $this->query[$end];
        return $this;   
    }

/////////////////////////////////////////////////////////////////////
  
/////////////////////////////////////////////////////////////////////
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
    public function validate($data, $rules){
        $rules = $this->rules[$rules];
        Validator::langDir(ROOT.'/public/valitron/lang');
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($rules);
       // $this->rules = [];
        if($v->validate()){
            return true;
        }
        $this->errors = $v->errors();
        return false;
    }

/////////////////////////////////////////////////////////////////////
    /** 
    * Задать свойства объекта
    */ 
    public function __call($name, $args)
    {
       if (in_array($name, array_keys($this->query))){
           if($name == 'table'){
               if(!empty($args[0])){
                    $this->query["table"] = $args[0];
               }else{
                    $this->query["table"] = static::$table;
               }
           }elseif(!empty($args[0])){
               $this->query["$name"] = strtoupper(str_replace ('_', ' ', $name)) . ' ' . $args[0]; 
           } 
       }else{
           $this->$name = $args[0];
       }
       return $this; 
    }

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////

    // /**
    //  * $arr массив свойств, которые удалить из объекта obj
    //  */
    // public function objMinimum(Model $obj, array $arr = null) {
    //     if($arr == null) $arr = static::$coreProps;
    //     if(!is_array($arr)) throw new \Exception("not array", 500);
    //      //  print_r($arr); die;
    //     foreach($obj as $prop=>$v){
    //         if(!in_array($prop, $arr)){
    //             unset($obj->$prop);
    //         }
    //     }
    //     return $obj;
    // }


/////////////////////////////////////////////////////////////////////
    /**
     *  
     */ 
    public function id() 
    {
        static::$pk = static::$pk ?: 'id';
        return $this;
    }
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */ 
    public function order_by_id($order = 'ASC') 
    {
        $this->order_by(static::$pk .' '. $order);
        return $this;
    }

/////////////////////////////////////////////////////////////////////

    /**
     * 
     */ 
    public function getErrors(){
        return $this->errors;
     }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
    public function setError(string $error){
        $this->errors['others'][] = $error;
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
    //public function save() {
        //$sql = "INSERT INTO user(login,password, name, email) VALUES ($login, $password, $name, $email)";
    //}

/////////////////////////////////////////////////////////////////////
    
/////////////////////////////////////////////////////////////////////
    // /**
    //  * 
    //  * getObjById == findPartObjByField. но поля по умолчанию $coreProps и id может быть не числом (и $pk id только по умолчанию)
    //  */ 
    // public function findPartObjByField($id, array $fields = null, string $pk = '') {
    //     $pk = $pk ?: $this->pk;
    //     if($fields == null) $fields = static::$coreProps;
    //     $fields = implode(", ", $fields);
    //     //$id = $this->clearInt($id);
    //         $sql  = "SELECT $fields
    //         FROM ".static::$table."
    //         WHERE $pk = ?";
    // return $data = DB::prepare($sql)->execute([$id])->fetchObject(static::class);
    // }
    

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////

    // /**
    //  * 
    //  * запись в таблице по полю в виде объекта
    //  * $id array
    //  * 
    //  */ 
    // public function findObjByWhere($val, $where) {
    //     //$field = $field ?: $this->pk;
    //         $sql  = "SELECT *
    //         FROM ".static::$table." " .$where;
    //         //var_dump($sql); die;
    // return $data = DB::prepare($sql)->execute($val)->fetchObject(static::class);
    // }
    
    
/////////////////////////////////////////////////////////////////////       
    // /**
    //  * 
    //  * запись в таблице по полю в виде объекта
    //  */ 
    // public function findObjByField($id, $field ='') {
    //     $field = $field ?: $this->pk;
    //         $sql  = "SELECT *
    //         FROM ".static::$table."
    //         WHERE $field = ?";
    // return $data = DB::prepare($sql)->execute([$id])->fetchObject(static::class);
    // }    
 
        

/////////////////////////////////////////////////////////////////////
    // /**
    //  * 
    //  * запись в таблице по первичному ключу
    //  */ 
    // public function findRowByField($id, $field ='') {
    //     $field = $field ?: $this->pk;
    //         $sql  = "SELECT *
    //         FROM ".static::$table."
    //         WHERE $field = ?
    //         LIMIT 1";
    // return $data = DB::prepare($sql)->execute([$id])->fetch();
    // }    
    
/////////////////////////////////////////////////////////////////////

    // /**
    //  * 
    //  * используется напр. в goods->countGoodsByCat($id)
    //  */
    // public function countRowIdByField($nameRowId, $nameField, $idField) {
    //     $idField = $this->clearInt($idField);
    //     $sql  = "SELECT
    //         COUNT($nameRowId)
    //         FROM ".static::$table."
    //         WHERE  $nameField = ?";
    // return $data = DB::prepare($sql)->execute([$idField])->fetchColumn();
    // }
    
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
            throw new \Exception ('Не число', 404);
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