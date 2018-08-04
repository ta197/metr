<?php
namespace application\models;

class View
{
    protected $data = [];
    
    public function __construct(){
        
        $this->data['h1'] = '';
        $this->data['subh1'] = '';
        $this->data['counter'] =  ['counted' =>'', 'counter'=>''];
        $this->data['componentLinkBRC'] = '';
        $this->data['is_admin'] = 0;
        $this->data['query'] = '';
        $this->data['errQuery'] = '';
                
    }

    public function navStatus(...$items){
        $navStatus = [
            'SearchActiv' => " nav__icon_activ",
            'SearchDisabled' => ' nav__icon_disabled',
            'CompanyActiv' => " nav__icon_activ",
            'CompanyDisabled' => ' nav__icon_disabled',
            'CategoryActiv' => " nav__icon_activ",
            'CategoryDisabled' => ' nav__icon_disabled',
            'AboutActiv' => " footer__nav-item_activ",
            'AboutDisabled' => ' footer__nav-item_disabled',
            'ContactsActiv' => " footer__nav-item_activ",
            'ContactsDisabled' => ' footer__nav-item_disabled',
            'PartnersActiv' => " footer__nav-item_activ",
            'PartnersDisabled' => ' footer__nav-item_disabled'
        ];

        foreach($navStatus as $element => $value):
            if(!in_array($element, $items)){
                $navStatus[$element] = '';
            }
        endforeach;
        return $navStatus;
    }

    public function __set($k, $v)
    {
        switch ($k):
            case 'query': $v = '&laquo;'.$v.'&raquo;'; break;
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
    
}

