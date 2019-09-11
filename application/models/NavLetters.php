<?php
namespace application\models;

use engine\core\db\DB, 
    engine\core\base\Model;

class NavLetters extends Model
{
    static public $table = 'companies';
    public $letter;
    public $ancor = false;
    public $type_letter = 'letter';
    public $full_list;
    public $unique_list;
    public $cyrrilic_list = [];
    public $list;
    static public $sql;
    public $base_url;
    public $count_full;
    static public $coreProps = ['letter', 'type_letter', 'list'];
    
/////////////////////////////////////////////////////////////////////
   /**
    * 
    */   
    public function __construct($base_url = '', $type_letter = '', $letter = NULL){
        $this->base_url = !empty($base_url) ? $base_url : 'company/alphabet';
        $this->type_letter = !empty($type_letter) ? $type_letter : 'letter';
        $this->letter = !empty($letter) ? $letter : '';
    }

/////////////////////////////////////////////////////////////////////
    /**
    * получаем весь список неуникальных анкоров
    */    
    public function companyAncors($where = 'c.archive IS NULL', $sort = 'ASC',  $param = [])
    {
        $join = '`places` AS p ON (p.company_id =  c.company_id) 
                    LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
                    LEFT JOIN `legal` ON (legal.id = c.legal)';
        
        switch($this->type_letter):
            case 'year': $field = 'c.year AS ancor'; break;
            case 'letter': $field = 'LEFT(c.company, 1) AS `ancor`'; break;
        endswitch;
        
        $this->full_list = $this
                        ->table('`companies` AS c')
                        ->fields([$field])
                        ->left_join($join)
                        ->where($where)
                        ->group_by('c.company_id')
                        ->order_by('`ancor` '. $sort)->select()
                        ->fetchAll($param);
//var_dump($this->full_list); die;
       
        $this->run();
        return $this;
    }

/////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function run()
    {
        switch($this->type_letter):
            case 'year': 
                    $this->uniqueAncors()->countFull()->cleanUniqueList(); break;
            case 'letter': 
                    $this->uniqueAncors()->countFull()->isCyrillicAlphabet()->clean(); break;
        endswitch;
       
        return $this; 
    }

/////////////////////////////////////////////////////////////////////
    /**
    * получаем весь список неуникальных анкоров
    * по-старому (чтобы не трогать фильтр)
    */    
    public function getAncorsForFilter($where = 'WHERE c.archive IS NULL ', $sort = 'ASC',  $andWhere ='')
    {
        static::$sql = "SELECT
            LEFT(c.company, 1) AS ancor
            FROM `companies` AS c
            LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
            LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
            LEFT JOIN `legal` ON (legal.id = c.legal)
            $where $andWhere
            GROUP BY c.company_id
            ORDER BY ancor $sort";
        
        $this->full_list = $this->fetchAll();
        // if($order === "c.rating DESC, c.company "){
        //  return '';
        // }
        $this->run();
        return $this;
    }


///////////////////////////////////////////////////////////////////// 
    /**
    * группировка под одним подзаголовком -- буква или год
    */   
    public function uniqueAncors()
    {
        $letters = array_column($this->full_list, 'ancor');
        $this->unique_list = array_unique($letters);
        $this->list = $this->unique_list;
        return $this;
    }

///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function isCyrillicAlphabet()
    {
        if(!is_array($this->unique_list)) return $this;

        foreach ($this->unique_list as $value){
            if( preg_match("/^[А-Яа-я]/", $value))
                $this->cyrrilic_list[] = $value;
        }
        $this->list = $this->cyrrilic_list;
        return $this;
    }

///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function cleanUniqueList()
    {
        $this->unique_list = null;
        return $this;
    }

///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function cleanCyrrilicList()
    {
        $this->cyrrilic_list = null;
        return $this;
    }

///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function clean()
    {
        $this->cyrrilic_list = null;
        $this->unique_list = null;
        return $this;
    }


///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function countFull()
    {
        if(!empty($this->full_list)){
          $this->count_full = count($this->full_list);
        }
        $this->full_list = null;
       
        return $this; 
    }

///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function setAncor()
    {
        $this->ancor = true;
        return $this; 
    }

///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function setTypeLetter($type)
    {
        $this->type_letter = $type;
        return $this; 
    }

///////////////////////////////////////////////////////////////////// 


/////////////////////////////////////////////////////////////////////
}

