<?php
namespace application\models;

class Filters2 extends Model
{
    public $legal = null;
    
    public $countShop = 0;

    public $shop;
    public $service;
    public $manuf;

    public $ip;
    public $ooo;
    public $oao;

    public $asc;
    public $desc;
    public $rating;

    public function __construct($decode){
        parent::__construct();
        if(!$decode){
            $this->defaultItem(); return;
        }
        foreach($decode as $k=>$value){
            if($k == 'business'){
                foreach($value as $v){
                    switch($v->item):
                        case "shop": 
                            $this->shop = new FiltersItem($v); break;
                        case "service": 
                            $this->service = new FiltersItem($v); break;
                        case "manuf": 
                            $this->manuf = new FiltersItem($v); break;
                    endswitch;
                }
            }
            if($k == 'legal'){
                foreach($value as $v){
                    if($v->checked)
                        $this->legal[]= '\''.$v->value.'\'';
                    switch($v->item):
                        case "ip": 
                            $this->ip = new FiltersItem($v); break;
                        case "ooo": 
                            $this->ooo = new FiltersItem($v); break;
                        case "oao": 
                            $this->oao = new FiltersItem($v); break;
                    endswitch;
                }
            }
            if($k == 'progression'){
                foreach($value as $v){
                    switch($v->item):
                        case "asc": 
                            $this->asc = new FiltersItem($v); break;
                        case "desc": 
                            $this->desc = new FiltersItem($v); break;
                        case "rating": 
                            $this->rating = new FiltersItem($v); break;
                    endswitch;
                }
            } 
        }
        $this->defaultItem(); 
    }

    public function defaultItem(){
        if(!$this->shop) $this->shop = new FiltersItem();
        if(!$this->service) $this->service = new FiltersItem();
        if(!$this->manuf) $this->manuf = new FiltersItem();
        if(!$this->ip) $this->ip = new FiltersItem();
        if(!$this->ooo) $this->ooo = new FiltersItem();
        if(!$this->oao) $this->oao = new FiltersItem();
        if(!$this->asc) $this->asc = new FiltersItem();
        if(!$this->desc) $this->desc = new FiltersItem();
        if(!$this->rating) $this->rating = new FiltersItem();
    }

    public function combineWhere() //форирует WHERE для бизнес, legal
    {
        $where ='';
        
        $shop = $this->shop->checked;
        $service = $this->service->checked;
        $man = $this->manuf->checked;

        if(!empty($this->legal)){
            $legalStr = implode(', ', $this->legal);
            $where .= 'legal.name IN ('. $legalStr.')';
            if((!$shop) and (!$service) and (!$man)){
                if($this->ip->count) 
                    $this->ip->curr = $this->ip->count;
                if($this->ooo->count) 
                    $this->ooo->curr = $this->ooo->count;
                if($this->oao->count) 
                    $this->oao->curr = $this->oao->count;
            }
            if($shop || $service || $man){
                $where .= ' AND ';
            } 
        }
        if($shop and $service and $man){
            $where .= '(p.service = 1 OR p.manufacturing = 1 OR sh.name IS NOT NULL)';
        }else if($shop and $service and !$man){
            $where .= '(p.service = 1 OR sh.name IS NOT NULL)';
                if(!($this->legal)) $this->manuf->curr = $this->manuf->count;
        }else if($shop and (!$service) and (!$man)){
            $where .= '(sh.name IS NOT NULL)';
                if(!($this->legal)) $this->service->curr = $this->service->count;
                if(!($this->legal)) $this->manuf->curr = $this->manuf->count;
        }else if((!$shop) and ($service and $man)){
            $where .= '(p.service = 1 OR p.manufacturing = 1)';
                if(!($this->legal)) $this->shop->curr = $this->shop->count;
        }else if((!$shop) and (!$service) and $man){
            $where .= '(p.manufacturing = 1)';
                if(!($this->legal)) $this->shop->curr = $this->shop->count;
                if(!($this->legal)) $this->service->curr = $this->service->count;
        }else if(!$shop and $service and !$man){
            $where .= 'p.service = 1';
                if(!($this->legal)) $this->shop->curr = $this->shop->count;
                if(!($this->legal)) $this->manuf->curr = $this->manuf->count;
        }else if($shop and (!$service) and $man){
            $where .= '(p.manufacturing = 1 OR sh.name IS NOT NULL)';
                if(!($this->legal)) $this->service->curr = $this->service->count;
        }

        if($where)
            $where = 'WHERE '.$where;
        return $where;
    }

    public function getFilters($where='')
    {
        $this->renewCurrentBusiness($this->getBusinessFromDB($where));
        $business= $this->responseBusiness();
        $this->renewCurrentLegal($this->getLegalFromDB($where));
        $legal= $this->responseLegal();
        $progression= $this->responseProgression();
       
        return new ResponseFilter($business, $legal, $progression);
    }

    public function getBusinessFromDB($where) //данные только по business и shop, готовые
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
     
        if($this->shop->curr == '-1')
            $this->shop->curr = $this->countShop;
        if($this->service->curr == '-1')
            $this->service->curr = $business[0]['countService'];
        if($this->manuf->curr == '-1')
            $this->manuf->curr = $business[0]['countManufacturing'];
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
            if(!empty($this->shop->curr) and ($this->shop->curr !== '-1')){
                $business[] = ['value'=>'торговля','item'=>"shop", 'checked'=>$this->shop->checked, 'group' => "business", 'type'=> "checkbox", 'name' => 'shop', 'count'=> $this->shop->curr];
            }
            if(!empty($this->service->curr) and ($this->service->curr !== '-1')){
                $business[] = ['value'=>'услуги', 'item'=>"service",  'checked'=> $this->service->checked, 'group' => "business", 'type'=> "checkbox", 'name' => 'service', 'count'=>$this->service->curr];  
            }
            if(!empty($this->manuf->curr) and ($this->manuf->curr !== '-1'))
                $business[] = ['value'=>'производство', 'item'=>"manuf", 'checked'=> $this->manuf->checked, 'group' => "business", 'type'=> "checkbox", 'name' => 'manuf', 'count'=>$this->manuf->curr];
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
        GROUP BY legal.name
        ";
        return self::$db->queryAll(
            $sql
        );
    }

    public function renewCurrentLegal($legal)
    {
        if($legal){
            foreach($legal as $v):
                switch($v['legal']):
                    case "ИП": 
                        $this->ip->curr = $v['countLegal']; break;
                    case "ООО": 
                        $this->ooo->curr = $v['countLegal']; break;
                    case "ОАО":
                        $this->oao->curr = $v['countLegal']; break;
                endswitch;
            endforeach;
        }  
    }
    
    public function responseLegal()
    {   
        $legal =[];
        if(!empty($this->ip->curr) and ($this->ip->curr !== '-1')) 
            $legal[] = ['value'=>'ИП', 'item'=>'ip', 'checked'=> $this->ip->checked, 'group' => "legal", 'type'=> "checkbox", 'name' => 'ip', 'count'=> $this->ip->curr];
        if($this->ooo->curr !== '-1') 
            $legal[] = ['value'=>'ООО', 'item'=>'ooo', 'checked'=> $this->ooo->checked, 'group' => "legal", 'type'=> "checkbox", 'name' =>'ooo', 'count'=> $this->ooo->curr];
        if(!empty($this->oao->curr) and ($this->oao->curr !== '-1')) 
            $legal[] = ['value'=>'ОАО',  'item'=>'oao', 'checked'=> $this->oao->checked, 'group' => "legal", 'type'=> "checkbox", 'name' =>'oao', 'count'=> $this->oao->curr];
        return $legal;
    }

    public function responseProgression()
    {
        $progression = [];
        $progression[]= ['type'=>"radio", 'item'=>'asc', 'value'=> "по названию, А-Я", 'checked' => $this->asc->checked, 'group'=> "progression", 'name' => "progression", 'count'=> 0];
        $progression[]= ['type'=>"radio", 'item'=>'desc', 'value'=> "по названию, Я-А", 'checked' => $this->desc->checked, 'group'=> "progression", 'name' => "progression", 'count'=> 0];
        $progression[]= ['type'=>"radio", 'item'=>'rating', 'value'=> "по рейтингу", 'checked' => $this->rating->checked, 'group'=> "progression", 'name' =>"progression", 'count'=> 0];
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
   
}