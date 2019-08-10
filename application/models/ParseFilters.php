<?php
namespace application\models;
use  vendor\engine\core\base\DB, vendor\engine\core\Model;
class ParseFilters extends Model
{
    
/////////////////////////////////////////////////////////////////////   
    public function decodeFilters()
    {

        $rawPost = file_get_contents('php://input');
        if ($rawPost) {

            $raw = json_decode($rawPost);
                        
        } else {
            // Данные не переданы
            echo json_encode(
                array
                (
                    'result' => 'No data'
                )
            );
        }
        return $raw;
    }
    
/////////////////////////////////////////////////////////////////////
    public function queryFilters(){
        if(isset($_GET)) {
            $raw =[];
            foreach($_GET as $k=>$v){
                foreach($v as $value){
                    if($value !=='не указано' && $value !=='нет данных'){
                        $raw[$k][]=(object)['value' => $value,
                        'checked' => true, 'name'=>$k.'[]'];
                    }
                    
                }
            }
            return (object)$raw;
        }
    }
    
/////////////////////////////////////////////////////////////////////
}