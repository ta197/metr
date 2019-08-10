<?php
namespace  vendor\engine\core;

use application\models\View;

class RouteController
{
    public $route;
    public $file_layout = LAYOUT_DEFAULT_FILE;
    public $view;
    protected $fc;
    public $file_view;
    public $output;

    public function __construct($fc)
    {
        $this->fc = $fc;
        $this->route = $fc->route;
        $this->file_view =  $this->route['action'];
        $this->view = new View($this->route);
    }

    public function runView()
    {
        $this->view->file_view =  $this->file_view;
        $this->view->file_layout =  $this->file_layout;

        $this->output = $this->view->render();
        $this->fc->setBody($this->output);
    }

    protected function checkParams(array $required, array $add = [])
    {
        $par = $this->fc->getParams();
            if(null == $par) throw new \Exception("нет параметров", 404);

        $array_key = array_keys($par);
        $full = array_merge($required, $add);

        $need = array_diff($required, $array_key);
        if(!empty($need)){
            $need = implode(', ', $need);
            throw new \Exception("нет параметра &laquo;$need&raquo;", 404);
        }

        $extra = array_diff($array_key, $full);
        if(!empty($extra)){
            $extra = implode(', ', $extra);
            throw new \Exception("Несуществующий параметр &laquo;$extra&raquo;", 404);
        }
        foreach($par as $k=>$v){
            $int = (int)$v;
            if(empty ($int))
                throw new \Exception("параметр &laquo;$k&raquo; не число, а &laquo;$v&raquo;", 404);
        }
        return $par;
    }

    protected function checkOneParam($param)
    {
        $par = $this->fc->getParams();
        if(null == $par) throw new \Exception("нет параметров", 404);
        $array_key = array_keys($par);
        $extra = array_diff($array_key, [$param]);
        if(!empty($extra)){
            $extra = implode(', ', $extra);
            throw new \Exception("Несуществующий параметр $extra", 404);
        }
        if(!isset ($par[$param]))
            throw new \Exception("нет параметра $param", 404);   
        $p = (int)$par[$param];
        if(empty ($p))
            throw new \Exception("id $param не число", 404);
        return $p;
    }

}