<?php
namespace application\models;

class View
{
    public $data = [
        'is_admin'=> 0,
        'title'=> 'справочник',
        'counter' => ''
    ];
    public $route;
    public $file_layout = LAYOUT_DEFAULT_FILE;
    public $file_view;

    
    public function __construct($route){
        $this->route = $route;

    }

    // public function findLayoutByModul() {

    //     switch($this->route['modul']):
    //         case 'admin':  
    //             $this->file_layout = 'admin';
    //             break;
    //         case 'petrova':  
    //             $this->file_layout = 'petrova';
    //             break;
    //         case 'main':  
    //             $this->file_layout = LAYOUT_DEFAULT_FILE;
    //             //$this->route['controller'] ='err';
    //            break;    
    //         default: 
    //            $this->file_layout = DEFAULT_ERR;
    //            $this->route['controller'] ='err';
    //     endswitch;
    // }

    public function render() {
            $file_view = "././application/views/{$this->route['modul']}/{$this->route['controller']}/{$this->file_view}.php";
            ob_start();
            foreach ($this->data as $prop=> $value){
                $$prop = $value;
            }
    
            if(is_file($file_view)){
                include ($file_view);
            }else{
               throw new \Exception("Не найден вид {$file_view}", 500);
            }
        
            $content = ob_get_clean();
        
            if(false === $this->file_layout) return $content;
        
            $file_layout = "././application/views/layouts/{$this->file_layout}.php";
        
            if(is_file($file_layout)){
                include_once $file_layout;
            }else{
                //echo $file_layout = "Не найден шаблон {$file_layout}";
                throw new \Exception("Не найден шаблон {$file_layout}", 500);
            }
    }

    public function navStatus($menu, ...$items){
        $navStatus = [
            'metr'=>
                ['SearchActiv' => " nav__icon_activ",
                'SearchDisabled' => ' nav__icon_disabled',
                'CompanyActiv' => " nav__icon_activ",
                'CompanyDisabled' => ' nav__icon_disabled',
                'CategoryActiv' => " nav__icon_activ",
                'CategoryDisabled' => ' nav__icon_disabled'],
            'about'=>
                ['AboutActiv' => " footer__nav-item_activ",
                'AboutDisabled' => ' footer__nav-item_disabled',
                'ContactsActiv' => " footer__nav-item_activ",
                'ContactsDisabled' => ' footer__nav-item_disabled',
                'PartnersActiv' => " footer__nav-item_activ",
                'PartnersDisabled' => ' footer__nav-item_disabled'],
            'admin'=>
                ['CatalogActiv' => " nav__icon_activ",
                'CatalogDisabled' => ' nav__icon_disabled',
                'CompanyActiv' => " nav__icon_activ",
                'CompanyDisabled' => ' nav__icon_disabled',
                'IndexActiv' => " nav__icon_activ",
                'IndexDisabled' => ' nav__icon_disabled',
                'CategoryActiv' => " nav__icon_activ",
                'CategoryDisabled' => ' nav__icon_disabled',
                'UserActiv' => " nav__icon_activ",
                'UserDisabled' => ' nav__icon_disabled'],
            'rezume' => 
                ['DevelopDisabled' => ' footer__nav-item_disabled',
                'DevelopActiv' => " footer__nav-item_activ",
                'DesignDisabled' => ' footer__nav-item_disabled',
                'DesignActiv' => " footer__nav-item_activ",
                'ProofsDisabled' => ' footer__nav-item_disabled',
                'ProofsActiv' => " footer__nav-item_activ",
                'EducationDisabled' => ' footer__nav-item_disabled',
                'EducationActiv' => " footer__nav-item_activ",
                'ExperienceDisabled' => ' footer__nav-item_disabled',
                'ExperienceActiv' => " footer__nav-item_activ",
                'AddDisabled' => ' footer__nav-item_disabled',
                'AddActiv' => " footer__nav-item_activ",
                'IndexRezumeDisabled' => ' footer__nav-item_disabled',
                'IndexRezumeActiv' => " footer__nav-item_activ"]    
        ];

        //foreach($navStatus as $element => $value):
       //     if(!in_array($element, $items)){
       //         $navStatus[$element] = '';
       //     }
       // endforeach;
       
       foreach($navStatus as $element => $value):
        if(!in_array($element, $menu)){
             $navStatus[$element] = '';
           }
        else{
            foreach($value as $key => $v){
                if(!in_array($key, $items)){
                    $navStatus[$element][$key] = '';
                }
               
            }
        }
         
        endforeach;

        return $navStatus;
    }

    public function __set($k, $v)
    {
        switch ($k):
            //case 'query': $v = '&laquo;'.$v.'&raquo;'; break;
            case 'quote_query': $v = self::quote_ucfirst($v); 
                                break;
            case 'counter': $v = (int)$v; 
                            $this->data['counter'] = $v; 
                            break;
          
        endswitch;
        $this->data[$k] = $v; 
    }    
  
    public function __get($k)
    {
        return $this->data[$k];
    }

    public function setFileView($file_view){
        $this->file_view = $file_view;
    }
    
     public function __isset($k)
    {
       switch ($k){
           case 'goods': 
                    return !empty($this->goods); 
                    break;
           default: return false;

       }
    }
    
    public function display($template)
    {
       include $template;
    }

   


 /* 
    public function render($file) {
    // $file - текущее представление 
    ob_start();
    foreach ($this->data as $prop=> $value){
            $$prop = $value;
        }
    include($file);
    $content = ob_get_contens();
    ob_end_clean();
    return $content;
    }
 */

 /////////////////////////////////////////////////////////////////////
    /**
     * 
     */       
    public static function ucfirst_utf8($str) {
        return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr(mb_strtolower($str, 'utf-8'), 1, mb_strlen($str)-1, 'utf-8');
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */       
    public static function quote($str) {
        return '&laquo;'.$str.'&raquo;';
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */       
    public static function quote_ucfirst($str) {
        return '&laquo;'.static::ucfirst_utf8($str).'&raquo;';
    }

/////////////////////////////////////////////////////////////////////    
}

