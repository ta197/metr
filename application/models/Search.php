<?php
namespace application\models;

class Search extends Model
{
    public $query;
    private $exceptionWords = [
        'ИП', 'ООО', 'ТЦ', 'БЦ', 'ДВП', 'ДСП', 'ДОМ', '№1', 'ПР.', 'УЛ.'
        ];

    public function __construct(){
        parent::__construct();  
    }
////////////////////////////////////////////////////////////////

    public function clearQuery($query)
    {
        $ex = explode("=", $query);
        $q = $ex[1];
        //var_dump($q);
        $q = str_replace('%22', '', $q);
        $q = urldecode($q);
        $q = str_replace('«', '', $q);
        $q = str_replace('»', '', $q);
        return $this->query = trim(strip_tags($q));
    }

    public function errorQueryExecution($str){
        $errorQueryExecution ='';
        if(!$str){
            $errorQueryExecution = 'Задан пустой поисковый запрос';
        }
        else if (mb_strlen($str) < 2) {
            $errorQueryExecution = 'Слишком короткий поисковый запрос';
        } else if (mb_strlen($str) > 64) {
            $errorQueryExecution = 'Слишком длинный поисковый запрос';
        }
        return $errorQueryExecution;
    }

//////////////////////////////////////////////////////////////////////////
    public function toWords($query)
    {
        $query = preg_replace("|[,:;?]+|","",$query);
        $words = explode(" ", $query);
        //var_dump($words);
        $arrWords = [];
        foreach($words as $word):
            
            if(mb_strlen($word)>3){
                $arrWords[] = $word;
            }
            if(in_array(mb_strtoupper($word), $this->exceptionWords)){
                $arrWords[] = $word;
            }
            if((int)$word!== 0){
                $arrWords[] = (int)$word;
                $arrWords[] = $word;
            }
        endforeach;
        if($arrWords ==null){
            return false;
        }
        return $arrWords;
    }

//////////////////////////////////////////////////////////////////////////////

    public function getSearch($arrWords)
    {
        foreach ($arrWords as $word){
            if(!empty($word)){
                $gsc[] = $this->getSearchCompany($word);
                $gscat[] = $this->getSearchCat($word);
                $gsg[] = $this->getSearchGoods($word);
                //$gsp[] = $this->getSearchPlace($word);
            }
        }
        if(!empty($gsc) OR !empty($gsg) OR !empty($gscat) 
        //OR !empty($gsp)
        ){
           $gsc = $this->countDistinctResponse($gsc);
           $gscat = $this->countDistinctResponse($gscat);
           $gsg = $this->countDistinctResponse($gsg);
           //$gsp = $this->countDistinctResponse($gsp);
           $responseArr = [
                'Компании' => $gsc,
                'Категории' => $gscat, 
                'Товары, услуги' => $gsg
                //, 'Местонахождения' => $gsp
            ];
        }
        if($responseArr == []) return false; 
            $rawData = $this->rawData($responseArr);
            if(!$rawData)  return false; 
                return $rawData;
    }

    public function getSearchCompany($word){
        return self::$db->queryAll(
            "SELECT
            c.company_id, 
            company_to_string(c.name_type, c.shop, c.legal, c.name_legal, c.quotes, c.company) AS name, 
            GROUP_CONCAT(CONCAT_WS('', places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, p.unit_floor, p.unit_not))
                        SEPARATOR '~~') 
                        AS addresses
            FROM `places` AS p
            JOIN `companies` AS c ON (p.company_id =  c.company_id)
            LEFT JOIN `centres` ON (p.centre = centres.id)
            WHERE c.company LIKE ?  OR p.city LIKE ?  OR centres.name_center LIKE ? OR c.shop LIKE ? OR p.street LIKE ?OR c.legal = ? OR p.house LIKE ?
            GROUP BY c.company_id
            ORDER BY c.company", 
            ["%$word%", "%$word%", "%$word%", "%$word%", "%$word%", "$word", "$word"]);
    }
    
    public function getSearchCat($word){
        return self::$db->queryAll(
            "SELECT cats.cat_id, cats.name
            FROM `cats` 
            WHERE cats.name LIKE ? AND cats.visible = 1", 
            ["%$word%"]);
    }

    public function getSearchGoods($word){
        return self::$db->queryAll(
            "SELECT goods.goods_id, goods.name
            FROM `goods` 
            WHERE goods.name LIKE ?",
            ["%$word%"]);
    }

    // public function getSearchPlace($word){
    //     return self::$db->queryAll(
    //         "SELECT CONCAT_WS(', ', p.city, p.street, p.house) AS name,
    //                 GROUP_CONCAT(p.place_id, '^', p.company_id SEPARATOR '~~') AS all_place_id,
    //                 centres.name_center
    //         FROM `places` AS p
    //         LEFT JOIN `centres` ON (p.centre = centres.id) 
    //         WHERE p.street LIKE ? OR p.city LIKE ? OR centres.name_center LIKE ? OR p.house LIKE ?
    //         GROUP BY name",
    //         ["%$word%", "%$word%", "%$word%", "$word"]);
    // }

    private function countDistinctResponse($inputArr)
    {
        $outputArr =[];
        $namesArr = [];
        
        if(!empty($inputArr)):
            foreach($inputArr as $v):
                foreach($v as $val):
                    $outputArr[$val['name']] = $val;
                    $namesArr[] = $val['name']; 
                endforeach;
            endforeach;
        endif;  
             
        $namesArr = array_count_values ($namesArr);
        $result = array_merge_recursive($namesArr, $outputArr);

        return $result;
    }
    
    public function rawData($arr)
    {
        $clearFromEmpty = [];
        foreach ($arr as $section=>$data){
            if(!empty($data)){
                $clearFromEmpty[$section] = $data;
            }
        }
        $sortSection = $this->sortSection($clearFromEmpty);
        return $sortSection;
    } 

    public function sortSection($clearFromEmpty)
    {
        foreach ($clearFromEmpty as $k=>$v){
            usort($clearFromEmpty[$k], $this->build_sorter('0'));
        }
        return $clearFromEmpty;
    } 

    public function build_sorter($key) {
        return function ($a, $b) use ($key) {
            return strnatcmp($b[$key], $a[$key]);
        };
    }

///////////////////////////////////////////////////////////////////////////////////////////////

    public function BySort($rawData){

        uasort ($rawData, function ($x, $y) {
            return ($x[0][0] < $y[0][0]);
        });
        //var_dump($rawData);
        return $rawData;
    }

}

