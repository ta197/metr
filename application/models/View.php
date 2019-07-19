<?php
namespace application\models;

class View
{
    protected $data = [
        'is_admin'=> 0,
        'title'=> 'справочник',
        'counter' => ''
    ];
    
    public function __construct(){
        
        //$this->data['h1'] = '';
        //$this->data['subh1'] = '';
        //$this->data['counted'] =  ''; // строка перед counter
       //$this->data['componentLinkBRC'] = ''; // строка в BRC 
       // $this->data['errQuery'] = '';
       // $this->data['query'] = ''; // используетс в empty_response.inc
        // $this->data['is_admin'] = 0;
        // $this->data['title'] = 'справочник';
        // $this->data['counter'] =  ''; // количество (у h1)        
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
                'CategoryDisabled' => ' nav__icon_disabled'],
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

    //по Борисову
    public function render($file) {
        //$file - текущее представление
        ob_start();
        foreach ($this->data as $prop=> $value){
            $$prop = $value;
        }
        include($file);
        return ob_get_clean();
        }

 /* 
  //по Степанцеву 
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

