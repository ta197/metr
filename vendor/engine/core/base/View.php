<?php
namespace engine\core\base;

class View
{
    public $data = [];
    public $route;
    public $file_layout = LAYOUT_DEFAULT_FILE;
    public $file_view;
    //public $nav = [];
    //public $page;

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */  
    public function __construct($route){
        $this->route = $route;
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */  
    public function render() {
            if (substr($this->file_view, 0, 7) !== 'widgets'){
                $file_view = ROOT."/application/views/{$this->route['modul']}/{$this->route['controller']}/{$this->file_view}.php";
            }else{
               $file_view = ROOT.'/vendor/engine/'.$this->file_view.'.php';
            }
           
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
        
            $file_layout = ROOT."/application/views/layouts/{$this->file_layout}.php";
        
            if(is_file($file_layout)){
                include_once $file_layout;
            }else{
                //echo $file_layout = "Не найден шаблон {$file_layout}";
                throw new \Exception("Не найден шаблон {$file_layout}", 500);
            }

            $view = ob_get_clean();
            return $view;
    }


/////////////////////////////////////////////////////////////////////
    /**
     * 
     */  
    public function __set($k, $v)
    {
        switch ($k):
            //case 'query': $v = '&laquo;'.$v.'&raquo;'; break;
            case 'quote_query': $v = self::quote_ucfirst($v); 
                                break;
            case 'counter': $v = (int)$v; 
                            $this->data['counter'] = $v; break;
            case 'page': $this->data['page'] = $v;   break;           
            //default: $this->data[$k] = $v; break;
        endswitch;
        $this->data[$k] = $v;
    }    

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */   
    public function __get($k)
    {
        return $this->data[$k];
    }


/////////////////////////////////////////////////////////////////////
    /**
     * 
     */     
     public function __isset($k)
    {
       switch ($k){
           case 'goods': 
                    return !empty($this->goods); 
                    break;
           default: return false;
       }
    }

/////////////////////////////////////////////////////////////////////
    /**
     * Будет вызываться после render()
     * будет заменять напр <editor>Тут текст</editor> на ckeditor
     * 
     * TODO parseSpecialTags()
     */     
    public function display($output)
    {
       $this->parseSpecialTags();
    }
   
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
    /**
     * @ depreceted
     */ 
    public function setFileView($file_view){
        $this->file_view = $file_view;
    }

///////////////////////////////////////////////////////////////////// 

}

