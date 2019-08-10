<?php
namespace application\models;
use  vendor\engine\core\base\DB, vendor\engine\core\Model;

class FiltersHandler extends Model
{
    public $legalStr = null;
    
    public $countShop = 0;

    public $shop;
    public $service;
    public $manuf;
    public $zeroB;

    public $ip;
    public $ooo;
    public $oao;
    public $zao;
    public $zeroL;

    public $asc;
    public $desc;
    public $rating;

    public $business = [];
    public $legal = [];
    public $progression = [];

    public $title = ['b'=>[], 'leg'=>[]];
    public $where = '';
    public $sort = 'ASC';
    public $order = 'c.company';

    public $error = '';

    public function __construct($decode)
    {
        //parent::__construct();
        if(!$decode){
            $this->defaultItem(); return;
        }
        foreach($decode as $k=>$value):
            if($k == 'business'){
                foreach($value as $v){
                    switch($v->value):
                        case "торговля": 
                            $this->shop = new FiltersItem($v); break;
                        case "услуги": 
                            $this->service = new FiltersItem($v); break;
                        case "производство": 
                            $this->manuf = new FiltersItem($v); break;
                    endswitch;
                }
            }
            if($k == 'legal'){
                foreach($value as $v){
                    if($v->checked){
                        $this->legalStr[]= '\''.$v->value.'\'';
                        $this->title['leg'][] = $v->value;
                    }
                        
                    switch($v->value):
                        case "ИП": 
                            $this->ip = new FiltersItem($v); break;
                        case "ООО": 
                            $this->ooo = new FiltersItem($v); break;
                        case "ОАО": 
                            $this->oao = new FiltersItem($v); break;
                        case "ЗАО": 
                            $this->zao = new FiltersItem($v); break;
                    endswitch;
                }
            }
            if($k == 'progression'){
                foreach($value as $v){
                    switch($v->value):
                        case "по названию, А-Я": 
                            $this->asc = new FiltersItem($v, $v->name, 'radio'); break;
                        case "по названию, Я-А": 
                            $this->desc = new FiltersItem($v, $v->name, 'radio'); 
                            if($this->desc->checked)  $this->sort = 'DESC';
                            break;
                        case "по рейтингу": 
                            $this->rating = new FiltersItem($v, $v->name, 'radio'); 
                                if($this->rating->checked)
                                    $this->order = 'c.rating DESC, c.company ';
                            break;
                    endswitch;
                }
            } 
        endforeach;
        $this->defaultItem(); 
    }

   
    public function combineWhere() //формирует WHERE и заголовок, переопределяет curr
    {
        $where ='';
        $businessArr = [];
        $businessString ='';
        $legalString ='';
        
        $shop = $this->shop->checked;
        $service = $this->service->checked;
        $man = $this->manuf->checked;

        if(is_array($this->legalStr)){
            $legalString = implode(', ', $this->legalStr);
            $where .= 'legal.name IN ('. $legalString.') ';
            if((!$shop) and (!$service) and (!$man)){
                if($this->ip->count) 
                    $this->currToCount($this->ip);
                if($this->ooo->count) 
                    $this->currToCount($this->ooo);
                if($this->oao->count) 
                   $this->currToCount($this->oao);
                if($this->zao->count) 
                   $this->currToCount($this->zao);
            }
            if($shop || $service || $man){
                $where .= ' AND ';
            } 
        }
        
        if($shop){
            $businessArr[] = 'p.shop IS NOT NULL';
            //if(!($this->legal)) $this->currToCount($this->shop);
            $this->title['b'][] = 'предприятия торговли';
        }
        if($service){
            $businessArr[] = 'p.service = 1';
           // if(!($this->legal)) $this->currToCount($this->service);
            $this->title['b'][] = 'услуги';  
        }
        if($man){
            $businessArr[] = 'p.manufacturing = 1';
           //if(!($this->legal)) $this->currToCount($this->manuf);
            $this->title['b'][] = 'производственные предприятия';  
        }

        if(is_array($businessArr))
            $businessString = implode(' AND ', $businessArr);
        
        if($businessString)
            $where .= '('.$businessString.')';

        if(!empty($where)){
            $where = 'WHERE (c.archive IS NULL) AND '.$where;
        }else{
            $where = ' WHERE c.archive IS NULL ';
        }

        $this->where = $where;   
        return $this;
    }


    public function getFilters()
    {
        $this->renewCurrentBusiness($this->getBusinessFromDB($this->where));
        $this->renewCurrentLegal($this->getLegalFromDB($this->where));

        $this->business = $this->responseItem([$this->shop, $this->service, $this->manuf]);
        $this->legal= $this->responseItem([$this->ip, $this->ooo, $this->oao, $this->zao]);
        
        if(empty($this->business) and empty($this->legal)){
            $this->where ='';
            $this->error = 'По выбранным условиям нет результата. Попробуйте фильтровать поэтапно: выбирая по одному параметру.';
            return;
        }
        if(empty($this->business) and !empty($this->legal)){
            $this->zeroB = new FiltersItem('не указано', 'business[]','checkbox', true, 0);
                foreach($this->legal as $items){
                    if(($items['checked'] == 'checked') and $items['count'] > 0)
                    $this->zeroB->curr += $items['count'];
                }
            $this->business = $this->responseItem([$this->zeroB]);
        }
        
        if(empty($this->legal) and !empty($this->business)){
            $this->zeroL = new FiltersItem('нет данных', 'legal[]', 'checkbox', true, 0);
                foreach($this->business as $items){
                    if(($items['checked'] == 'checked') and $items['count'] > 0)
                    $this->zeroL->curr = $items['count'];
                }
            $this->legal = $this->responseItem([$this->zeroL]);
        }
        
        $this->progression= $this->responseItem([$this->asc, $this->desc, $this->rating]);
   
        return new ResponseFilter($this->business, $this->legal, $this->progression);
    }

    public function responseItem($arr)
    {
        $arrItems=[];
        foreach($arr as $i):
            if ($i->type == "radio") $i->curr = 0;
            if(($i->type == "radio") || (!empty($i->curr) and ($i->curr !== '-1')))
                $arrItems[] = ['value'=>$i->value, 'checked'=>$i->checked, 
                                'type'=> $i->type, 'name' => $i->name, 
                                'count'=> $i->curr];
        endforeach;
        return $arrItems;
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////

    private function getBusinessFromDB($where) //данные только по business и shop, готовые
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
        ORDER BY sh.name";
       
        return $data = DB::prepare($sql)->execute()->fetchAll();  
    }

    private function getLegalFromDB($where) //данные только по legal, готовые
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
       
        return $data = DB::prepare($sql)->execute()->fetchAll();
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    private function renewCurrentBusiness($business)
    {
        $this->countShop($business);
     
        //if($this->shop->curr == '-1')
        if(!empty($this->countShop))
            $this->shop->curr = $this->countShop;
        else $this->shop->curr = 0;
        
        //if($this->service->curr == '-1')
        if(!empty($business[0]['countService'])){
            $this->service->curr = $business[0]['countService'];
        }else{
            $this->service->curr = 0;
        }
            
        //if($this->manuf->curr == '-1')
        if(!empty($business[0]['countManufacturing']))
            $this->manuf->curr = $business[0]['countManufacturing'];
        else $this->manuf->curr = 0;
    }

    private function countShop($business)
    {
        $arrShop =[];
        foreach($business as $row){
            if($row['shop'])
                $arrShop[$row['shop']] = $row['countShop'];
        }
        $this->countShop = array_sum ($arrShop);
    }

    private function renewCurrentLegal($legal)
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
                    case "ЗАО":
                        $this->zao->curr = $v['countLegal']; break;
                endswitch;
            endforeach;
        }  
    }

 //////////////////////////////////////////////////////////////////////////////////////////////////   
    
    private function currToCount($i){
        $i->curr = $i->count;
    }

    public function getTitle()
    {
        $str = "Все организации";
        $t = [];
        if(!empty($this->title['b']) || !empty($this->title['leg'] )){
            //if(!($this->title['b'] == 'производственные предприятия'))  $str = 'Предприятия ';
            foreach($this->title as $k=>$substr){
                if(!empty($substr)) $t[$k]= $this->enumeration($substr, $k);
            }
            if(!empty($t['leg']) and empty($t['b'])){
                switch($t['leg']):
                    case 'ИП': $t['leg'] = 'индивидуальные предприниматели (ИП)'; break;
                    case 'ООО': $t['leg'] = 'Общества с ограниченной ответственностью (ООО)'; break;
                    case 'ОАО': $t['leg'] = 'Открытые акционерные общества (ОАО)'; break;
                    case 'ЗАО': $t['leg'] = 'Закрытые акционерные общества (ЗАО)'; break;
                endswitch;
            }
            $str = implode(', ', $t);
        }else
            $str = 'Все компании';
        return $str;
    }

    private function enumeration($arr, $k)
    {
        $str = '';
        $count = count($arr);
        
        if($count > 2){
            $str = implode(', ', $arr);
        }
        else if ($count == 2){
            if($k == 'leg')
            $str = implode(' или ', $arr);
            else $str = implode(' и ', $arr);
        }
        else if($count === 1){
            $str = $arr[0];
        }
        return $str;
    }

    public function getSort(){
        return $this->sort;
    }

    public function getOrder(){
        return $this->order;
    }

    public function getWhere(){
        return $this->where;
    }
    
    public function getError(){
        return $this->error;
    }


    private function defaultItem()
    {
        if(!$this->shop) $this->shop = new FiltersItem('торговля');
        if(!$this->service) $this->service = new FiltersItem('услуги');
        if(!$this->manuf) $this->manuf = new FiltersItem('производство');
        if(!$this->ip) $this->ip = new FiltersItem('ИП', 'legal[]');
        if(!$this->ooo) $this->ooo = new FiltersItem('ООО', 'legal[]');
        if(!$this->oao) $this->oao = new FiltersItem('ОАО', 'legal[]');
        if(!$this->zao) $this->zao = new FiltersItem('ЗАО', 'legal[]');
        if(!$this->asc) $this->asc = new FiltersItem('по названию, А-Я', 'progression[]', 'radio', true);
        if(!$this->desc) $this->desc = new FiltersItem('по названию, Я-А', 'progression[]', 'radio');
        if(!$this->rating) $this->rating = new FiltersItem('по рейтингу', 'progression[]', 'radio');
    }
   
//WHERE legal.name IN ('ООО', 'ИП') AND (p.service = 1 OR p.manufacturing = 1 OR p.shop IN ('магазин', 'на заказ'))
   
}