<?php
namespace application\controllers;

use application\models\View;

class ParentController
{
    public $route;
    public $file_layout = LAYOUT_DEFAULT_FILE;
    public $view;
    protected $fc;
    public $file_view;
    public $output;

    public function __construct($route){
        $this->fc = FrontController::getInstance();
        $this->route = $route;
        $this->file_view = $route['action'];
       
       $this->view = new View($this->route);
      
    }

    public function runView(){
      
        $this->view->file_view =  $this->file_view;
        $this->view->file_layout =  $this->file_layout;
        

        $this->output = $this->view->render();
        $this->fc->setBody($this->output);
    }

    protected function checkParams(array $required, array $add = []){
        $par = $this->fc->getParams();
            if(null == $par) throw new AppException("нет параметров");

        $array_key = array_keys($par);
        $full = array_merge($required, $add);

        $need = array_diff($required, $array_key);
        if(!empty($need)){
            $need = implode(', ', $need);
            throw new AppException("нет параметра &laquo;$need&raquo;");
        }

        $extra = array_diff($array_key, $full);
        if(!empty($extra)){
            $extra = implode(', ', $extra);
            throw new AppException("Несуществующий параметр &laquo;$extra&raquo;");
        }
        foreach($par as $k=>$v){
            $int = (int)$v;
            if(empty ($int))
                throw new AppException("параметр &laquo;$k&raquo; не число, а &laquo;$v&raquo;");
        }
        return $par;
    }

    protected function checkOneParam($param){
        $par = $this->fc->getParams();
        if(null == $par) throw new AppException("нет параметров");
        $array_key = array_keys($par);
        $extra = array_diff($array_key, [$param]);
        if(!empty($extra)){
            $extra = implode(', ', $extra);
            throw new AppException("Несуществующий параметр $extra");
        }
        if(!isset ($par[$param]))
            throw new AppException("нет параметра $param");   
        $p = (int)$par[$param];
        if(empty ($p))
            throw new AppException("id $param не число");
        return $p;
    }

}