<?php
namespace application\models;
use  engine\core\db\DB, engine\core\base\Model;

class NavLetters extends Model
{
    public $letter;
    public $ancor = false;
    public $type_letter = 'letter';
    public $full_list;
    public $unique_list;
    public $cyrrilic_list = [];
    public $list;
    static public $sql;
    public $base_url = '/company/alphabet';
    public $count_full;
    static public $coreProps = ['letter', 'type_letter', 'list'];
    
/////////////////////////////////////////////////////////////////////
     /**
     * 
     */   
    public function __construct($base_url = '', $letter = NULL){
        $this->base_url = !empty($base_url) ? $base_url : '/company/alphabet';
        $this->letter = !empty($letter) ? $letter : NULL;
    }


/**
 * получаем весь список неуникальных анкоров
 * по-старому (чтобы не трогать фильтр)
 */    
  public function getAncorsForFilter($where = 'WHERE c.archive IS NULL ', $sort = 'ASC', $andWhere ='') //список начальных букв, включая латиницу и цифры // не уникальные, а все, чтобы посчитав знать кол-во компаний
  {
        $sql  = "SELECT
            LEFT(c.company, 1) AS ancor
            FROM `companies` AS c
            LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
            LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
            LEFT JOIN `legal` ON (legal.id = c.legal)
            $where $andWhere
            GROUP BY c.company_id
            ORDER BY ancor $sort";
        
        $this->full_list = DB::prepare($sql)->execute()->fetchAll();
        return $this;
  }

///////////////////////////////////////////////////////////////////// 
/**
 * 
 */  
 public function getAncorsByAlphabet($archive = 'IS NULL') //список начальных букв, включая латиницу и цифры // не уникальные, а все, чтобы посчитав, знать кол-во компаний
    {
        static::$sql  = "SELECT
            LEFT(c.company, 1) AS ancor
            FROM `companies` AS c
            LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
            LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
            LEFT JOIN `legal` ON (legal.id = c.legal)
            WHERE (c.archive $archive)
            GROUP BY c.company_id
            ORDER BY ancor ASC";
        $this->full_list = DB::prepare(static::$sql)->execute()->fetchAll();
        return $this;
    }

    
///////////////////////////////////////////////////////////////////// 
/**
 * 
 */  
    public function getAncorsByYears($archive = 'IS NULL') //список начальных букв, включая латиницу и цифры // не уникальные, а все, чтобы посчитав знать кол-во компаний
    {
        static::$sql  = "SELECT
            c.year AS ancor
            FROM `companies` AS c
            LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
            LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
            LEFT JOIN `legal` ON (legal.id = c.legal)
            WHERE c.archive $archive AND  c.year >= ?
            GROUP BY c.company_id
            ORDER BY ancor DESC";
         $this->full_list = DB::prepare(static::$sql)->execute([START_WORK_YEAR])->fetchAll();    
        return $this;
    }

    
///////////////////////////////////////////////////////////////////// 
/**
 * группировка под одним подзаголовком -- буква или год
 */   
    public function uniqueAncors($order='c.company')
    {
       // if($order === "c.rating DESC, c.company ") return '';
        $letters = array_column($this->full_list, 'ancor');
        $this->unique_list = array_unique($letters);
       // if(is_array($letters))
            return $this;
       // return [];
    }

///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function isCyrillicAlphabet()
    {
        if(!is_array($this->unique_list)) return;
        //$isCyrillicAlphabet = [];
        foreach ($this->unique_list as $value){
            if( preg_match("/^[А-Яа-я]/", $value))
                $this->cyrrilic_list[] = $value;
        }
        //if(is_array($isCyrillicAlphabet))
        return $this;
    }

///////////////////////////////////////////////////////////////////// 
   /**
    * 
    */ 
    public function list()
    {
        if(!empty($this->cyrrilic_list)){
            $this->list = $this->cyrrilic_list;
        }else{
            $this->list = $this->unique_list;
        }
        $this->cyrrilic_list = null;
        $this->unique_list = null;
        $this->countFull();

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
    public function ancor()
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

