<?php
namespace application\models;

class Helper
{
    public $array =[];
    
    
public static function wordsFromString($string, $from, $to) {
    $arr = explode(", ", $string);
    $slice = array_slice ($arr, $from, $to);
    return implode(", ",  $slice);
}

/**  
 * берет второй уровень вложенности массива и в нем берет только указанные ключи=>значения, складывает их в др. массив
 */
// public function ArrBySecondKey ($array, $key_name){ 
//     foreach ($array as $value){
//             foreach ($value as $k=>$v){
//                 $ret[] = $v[$key_name];
//             }
//     }
//     return $ret;
// }

/**  
 * берет  вложенные массивы и в них берет только указанные ключи=>значения, складывает их в др. массив
 */
public function arrByFirstKey ($array, $key_name){ 
    foreach ($array as $value){
        if($value[$key_name]){
            $this->array[] = $value[$key_name]; 
        }
             
    }
    return $this;
}


/**  
 * проверяет, чтобы значения массива были только словами, начинающимися с кириллической буква
 */
// public function isCyrillicAlphabet (){
//     foreach ($this->array as $value){
//         if( preg_match("/^[А-Яа-я]/", $value) ) {
//             $isCyrillicAlphabet[] = $value;
//         }
//     }
//     $this->array = $isCyrillicAlphabet;
//     return $this;
// }


}