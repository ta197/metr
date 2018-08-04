<?php
namespace application\models;

class Filters extends Model
{
    public $shopChecked = false;
    public $manufChecked = false;
    public $serviceChecked = false;

    public $oldShopCount = null;
    public $oldServiceCount = null;
    public $oldManufCount = null;
    
    public $legal = null;
    
    public $ipChecked = false;
    public $oooChecked = false;
    public $oaoChecked = false;
    
    public $oldIPCount = null;
    public $oldOOOCount = null;
    public $oldOAOCount = null;

    public $asc = false;
    public $desc =false;
    public $rating = false;

    public $currShop = '-1';
    public $currService = '-1';
    public $currManuf = '-1';

    public $countShop = 0;

    public $currIP ='-1';
    public $currOOO ='-1';
    public $currOAO ='-1';

    public $nameShop = 'shop';
    public $nameService = 'service';
    public $nameManuf = 'manuf';

    public $nameIP = 'ip';
    public $nameOOO = 'ooo';
    public $nameOAO = 'oao';

    public $nameProgress = "progression";

    public function __construct($decode){
        parent::__construct();
        if(!empty($decode))
            extract($decode);
            if(!empty($business)){
                foreach($business as $key=>$v){
                    switch($key):
                        case "торговля": 
                            $this->shopChecked= $v['checked']; 
                            $this->oldShopCount= $v['count']; 
                            //$this->nameShop= $v['name']; 
                            break;
                        case "услуги": 
                            $this->serviceChecked = $v['checked']; 
                            $this->oldServiceCount= $v['count']; 
                           // $this->nameService = $v['name']; 
                           break;
                        case "производство": 
                            $this->manufChecked = $v['checked']; 
                            $this->oldManufCount = $v['count']; 
                            //$this->nameManuf = $v['name']; 
                            break;
                    endswitch;
                }
            }

            if(!empty($legal)){
                foreach($legal as $key=>$v){
                    if($v['checked']){
                        $str = '\''.$key.'\'';
                        $this->legal[]= $str;
                    }
                }
                foreach($legal as $key=>$v){
                    switch($key):
                        case "ИП": 
                            $this->ipChecked= $v['checked'];
                            $this->oldIPCount= $v['count']; 
                            //$this->nameIP = $v['name']; 
                            break;
                        case "ООО": 
                            $this->oooChecked= $v['checked'];
                            $this->oldOOOCount= $v['count']; 
                           // $this->nameOOO = $v['name']; 
                            break;
                        case "ОАО": 
                            $this->oaoChecked= $v['checked'];
                            $this->oldOAOCount = $v['count'];
                            //$this->nameOAO = $v['name']; 
                            break;
                    endswitch;
                }
            }

            if(!empty($progression)){
                foreach($progression as $k=>$v){
                    switch($k):
                        case "по названию, А-Я": 
                            $this->asc= $v['checked']; break;
                        case "по названию, Я-А": 
                            $this->desc= $v['checked']; break;
                        case "по рейтингу": 
                            $this->rating= $v['checked']; break;
                    endswitch;
                }
            }
    }

    public function combineWhere() //форирует WHERE для бизнес, legal
    {
    $where ='';
        
    $service = $this->serviceChecked;
    $man = $this->manufChecked;
    $shop = $this->shopChecked;

    if(is_array($this->legal)){
        $legalStr = implode(', ', $this->legal);
        $where .= 'legal.name IN ('. $legalStr;
            if(!$shop and !$service and !$man){
                if($this->oldIPCount) 
                    $this->currIP = $this->oldIPCount;
                else $where .= ', \'ИП\'';
               
                if($this->oldOOOCount) 
                    $this->currOOO = $this->oldOOOCount;
                else $where .= ', \'ООО\'';
                                
                if($this->oldOAOCount) 
                    $this->currOAO = $this->oldOAOCount;
                else $where .= ', \'ОАО\'';   
            }
            $where .= ')';   
            if($shop || $service || $man){
                $where .= ' AND ';
            } 
    }else{
        $where .= '';       
    }

    if($shop and $service and $man){
        $where .= '(p.service = 1 OR p.manufacturing = 1 OR sh.name IS NOT NULL)';
    }else if($shop and $service and !$man){
        $where .= '(p.service = 1 OR sh.name IS NOT NULL)';
            if(!($this->legal)) $this->currManuf = $this->oldManufCount;
    }else if($shop and (!$service) and (!$man)){
        $where .= '(sh.name IS NOT NULL)';
            if(!($this->legal)) $this->currService = $this->oldServiceCount;
            if(!($this->legal)) $this->currManuf = $this->oldManufCount;
    }else if((!$shop) and ($service and $man)){
        $where .= '(p.service = 1 OR p.manufacturing = 1)';
            if(!($this->legal)) $this->currShop = $this->oldShopCount;
    }else if((!$shop) and (!$service) and $man){
        $where .= '(p.manufacturing = 1)';
            if(!($this->legal)) $this->currShop = $this->oldShopCount;
            if(!($this->legal)) $this->currService = $this->oldServiceCount;
    }else if(!$shop and $service and !$man){
        $where .= 'p.service = 1';
            if(!($this->legal)) $this->currShop = $this->oldShopCount;
            if(!($this->legal)) $this->currManuf = $this->oldManufCount;
    }else if($shop and (!$service) and $man){
        $where .= '(p.manufacturing = 1 OR sh.name IS NOT NULL)';
            if(!($this->legal)) $this->currService = $this->oldServiceCount;
    }else{
        $where .= '';
    }

    if($where){
        $where = 'WHERE '.$where;
    }
    return $where;
}

    public function getFilters($where="")
    {
        $this->renewCurrentBusiness($this->getBusinessFromDB($where));
        //$response[]= $this->responseBusiness();
        $business= $this->responseBusiness();
        $this->renewCurrentLegal($this->getLegalFromDB($where));
        //$response[]= $this->responseLegal();
        $legal= $this->responseLegal();
        //$response[]= $this->responseProgression();
       $progression= $this->responseProgression();
       // $raw = array_values($response);

        //return $raw;
        return new ResponseFilter($business, $legal, $progression);
    }

    public function getBusinessFromDB($where="") //данные только по business и shop, готовые
    {
        $sql = 
        "SELECT
        sh.name AS shop, COUNT(DISTINCT CONCAT_WS(',', p.street, p.house, p.company_id)) AS countShop,
        COUNT(p.service) AS countService, COUNT(p.manufacturing) AS countManufacturing        
        FROM `companies` AS c
        LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
        LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
        LEFT JOIN `legal` ON (legal.id = c.legal)
    $where
        GROUP BY sh.name
        ORDER BY sh.name
        ";
        
        return self::$db->queryAll(
            $sql
        );
    }

    public function renewCurrentBusiness($business)
    {
        $this->countShop($business);
     
        if($this->currShop == '-1')
            $this->currShop = $this->countShop;
        
        if($this->currService == '-1')
            $this->currService = $business[0]['countService'];
        
        if($this->currManuf == '-1')
            $this->currManuf = $business[0]['countManufacturing'];
    }

    public function countShop($business)
    {
        $arrShop =[];
        foreach($business as $row){
            if($row['shop'])
                $arrShop[$row['shop']] = $row['countShop'];
            }
        $this->countShop = array_sum ($arrShop);
    }

    public function responseBusiness()
    {
        $business =[];
            if(!empty($this->currShop) and ($this->currShop !== '-1'))
                $business[] = ['value'=>'торговля', 'checked'=> $this->shopChecked,  'group' => "business", 'type'=> "checkbox", 'name' => $this->nameShop, 'count'=> $this->currShop];
            if(!empty($this->currService) and ($this->currService !== '-1'))
                $business[] = ['value'=>'услуги',  'checked'=> $this->serviceChecked, 'group' => "business", 'type'=> "checkbox", 'name' => $this->nameService, 'count'=>$this->currService];  
            if(!empty($this->currManuf) and ($this->currManuf !== '-1'))
                $business[] = ['value'=>'производство',   'checked'=> $this->manufChecked, 'group' => "business", 'type'=> "checkbox", 'name' => $this->nameManuf, 'count'=>$this->currManuf];
        return $business;
    }

    
    public function getLegalFromDB($where) //данные только по legal, готовые
    {
        $sql =
        "SELECT
        legal.name AS legal, COUNT(DISTINCT c.company) AS countLegal
        FROM `companies` AS c
        LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
        LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
        LEFT JOIN `legal` ON (legal.id = c.legal)
   $where 
        GROUP BY legal.name";
        
        return self::$db->queryAll(
            $sql
        );
    }

    public function renewCurrentLegal($legal)
    {
        if($legal){
            foreach($legal as $k=>$v):
                switch($v['legal']):
                    case "ИП": 
                        //if($this->currIP === '-1') 
                            $this->currIP = $v['countLegal']; break;
                    case "ООО": 
                        //if($this->currOOO === '-1')
                            $this->currOOO = $v['countLegal']; break;
                    case "ОАО":
                        //if($this->currOAO === '-1')
                            $this->currOAO = $v['countLegal']; break;
                endswitch;
            endforeach;
        }  
    }

    
    public function responseLegal()
    {   
        $legal =[];
        if(!empty($this->currOOO) and ($this->currIP !== '-1')) 
            $legal[] = ['value'=>'ИП',  'checked'=> $this->ipChecked, 'group' => "legal", 'type'=> "checkbox", 'name' => $this->nameIP, 'count'=> $this->currIP];
        if($this->currOOO !== '-1') 
            $legal[] = ['value'=>'ООО', 'checked'=> $this->oooChecked, 'group' => "legal", 'type'=> "checkbox", 'name' => $this->nameOOO, 'count'=> $this->currOOO];
        if(!empty($this->currOAO) and ($this->currOAO !== '-1')) 
            $legal[] = ['value'=>'ОАО',  'checked'=> $this->oaoChecked, 'group' => "legal", 'type'=> "checkbox", 'name' => $this->nameOAO, 'count'=> $this->currOAO];
        return $legal;
    }


    public function responseProgression()
    {
        $progression = [];
        $progression[]= ['type'=>"radio", 'value'=> "по названию, А-Я", 'checked' => $this->asc, 'group'=> "progression", 'name' => $this->nameProgress, 'count'=> 0];
        $progression[]= ['type'=>"radio", 'value'=> "по названию, Я-А", 'checked' => $this->desc, 'group'=> "progression", 'name' => $this->nameProgress, 'count'=> 0];
        $progression[]= ['type'=>"radio", 'value'=> "по рейтингу", 'checked' => $this->rating, 'group'=> "progression", 'name' => $this->nameProgress, 'count'=> 0];
        return $progression;
    }


    public function getLettersByFilters() //список начальных букв, включая латиницу и цифры
    {
        return self::$db->queryAll(
            "SELECT
            LEFT(c.company, 1) AS letter
            FROM `companies` AS c
            LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
            LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
            LEFT JOIN `legal` ON (legal.id = c.legal)
        WHERE legal.name IN ('ООО', 'ИП') AND (p.service = 1 OR p.manufacturing = 1 OR sh.name IN ('магазин', 'на заказ'))
            GROUP BY letter
            ORDER BY letter"
        );
    }

    public function getCompaniesByFilters()
    {
        return self::$db->queryEach(
            "SELECT
            c.company, LEFT(c.company, 1) AS letter, c.company_id, c.site, c.rating,
            company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name,
            
            GROUP_CONCAT(CONCAT_WS('', a.ul, a.phone)
                        SEPARATOR '~~') 
                        AS addresses
            FROM `address_business` AS a
            RIGHT JOIN `companies` AS c ON (a.company_id =  c.company_id)
            
            LEFT JOIN `legal` ON (legal.id = c.legal)
        WHERE legal.name IN ('ООО', 'ИП') AND (a.service = 1 OR a.manufacturing = 1 OR a.shop IN ('магазин', 'на заказ'))
            GROUP BY c.company_id
            ORDER BY c.company ASC");
    }
   
    
    /*
    * 
     WHERE (a.service = 1 OR a.manufacturing = 1) OR (a.shop IS NOT NULL OR a.shop IS NULL)
            GROUP BY c.company_id
            ORDER BY c.rating DESC
    */


    /*WHERE (a.service = 1 OR a.manufacturing = 1) AND c.legal IN ('ООО', 'ОАО') OR a.shop IS NOT NULL */

/* представленние address //  SQL_NO_CACHE 
               CREATE VIEW address_business
AS
SELECT company_id,
places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, null, p.unit_not)
AS ul,
CONCAT_WS('^', company_id, places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, null, p.unit_not)) 
AS id_ul,
SUBSTRING_INDEX(GROUP_CONCAT(phones_to_string(p.tel, p.addtel, p.cell, p.add_cell) SEPARATOR ', '), ', ', 2)
AS phone,
p.service AS service, p.manufacturing AS manufacturing, sh.name AS shop
FROM `places` AS p
LEFT JOIN `centres` ON (p.centre = centres.id)
LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
GROUP BY id_ul
            */ 
    
    
    // public function getALLFilters() //считает place! неточные данные: legal - нужно убрать повторения, потом обработать; количество по business -считать, по shop - обрабатывать и считать; по letter обрабатывать 
    // {
    //     return self::$db->queryAll(
    //         "SELECT
    //         c.company, LEFT(c.company, 1) AS letter, sh.name AS shop, p.service AS service, p.manufacturing AS manufacturing, legal.name AS legal,  CONCAT_WS(',', p.street, p.house, p.company_id) AS addr
    //         FROM `companies` AS c
    //         LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
    //         LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
    //         LEFT JOIN `legal` ON (legal.id = c.legal)
    //     WHERE (service = 1 OR manufacturing = 1 OR sh.name IN ('магазин', 'на заказ')) AND legal.name IN ('ООО', 'ИП')
    //         GROUP BY addr
    //         ORDER BY c.company ASC"
    //     );
    // }

}