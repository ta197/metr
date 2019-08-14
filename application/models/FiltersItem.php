<?php
namespace application\models;
use  engine\core\Model;

class FiltersItem extends Model
{
    public $name;
    public $type;
    public $value;
    public $checked = false;
    public $count = null;
    public $curr = '-1';
    
/////////////////////////////////////////////////////////////////////
    public function __construct($obj, $name ='business[]', $type = 'checkbox', $check = false, $currentCount = '-1'){
        
        if(is_object($obj)){
            if(!empty($obj->count)) $this->count = $obj->count;
            $value = $obj->value;
            $this->checked = $obj->checked;
            $this->curr = '-1';
            $this->name = $obj->name;
        }else{
            $value = $obj;
            $this->checked = $check;
            $this->curr = $currentCount;
            $this->name = $name; 
        }
       
            $this->value = $value;
            $this->type = $type;
            //if($checked) { $this->checked = $checked; }
           
            //if($curr !== '-1') { $this->curr = $curr; }
            
            // switch($value):
            //     case "торговля":
            //         $this->name = 'business[]';
            //         $this->type = 'checkbox';
            //         if($checked) { $this->checked = $checked; } 
            //         break;

            //     case "услуги":
            //         $this->name = 'business[]';
            //         $this->type = 'checkbox';
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                    
            //     case "производство":
            //         $this->name = 'business[]';
            //         $this->type = 'checkbox';
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                
            //     case "не указано":
            //         $this->name = 'business[]';
            //         $this->type = 'checkbox';
            //         $this->curr = 0;
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                    
            //     case "ИП":
            //         $this->name = 'legal[]';
            //         $this->type = 'checkbox';
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                    
            //     case "ООО":
            //         $this->name = 'legal[]';
            //         $this->type = 'checkbox';
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                    
            //     case "ОАО":
            //         $this->name = 'legal[]';
            //         $this->type = 'checkbox';
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                
            //     case "ЗАО":
            //         $this->name = 'legal[]';
            //         $this->type = 'checkbox';
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                
            //     case "нет данных":
            //         $this->name = 'legal[]';
            //         $this->type = 'checkbox';
            //         $this->curr = 0;
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                    
            //     case "по названию, А-Я":
            //         $this->name = 'progression[]';
            //         $this->type = 'radio';
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                    
            //     case "по названию, Я-А":
            //         $this->name = 'progression[]';
            //         $this->type = 'radio';
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                    
            //     case "по рейтингу":
            //         $this->name = 'progression[]';
            //         $this->type = 'radio';
            //         if($checked) { $this->checked = $checked; } 
            //         break;
                    
            //     default:
            //         "не знаю";
            // endswitch;
       
            
    }
    
/////////////////////////////////////////////////////////////////////   
}