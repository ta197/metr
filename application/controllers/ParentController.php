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
        //$this->file_layout = LAYOUT_DEFAULT_FILE;
       $this->view = new View($this->route);
        //return $this;
    }

    public function runView(){
        //$this->route = $route;
        //$this->file_view = $route['action'];
        //$this->file_layout = $this->file_layout ?: LAYOUT_DEFAULT_FILE;

        //$this->view = new View($this->route, $this->file_layout, $this->file_view);
        $this->view->file_view =  $this->file_view;
        $this->view->file_layout =  $this->file_layout;
//if(empty($this->output)){
    $this->output = $this->view->render();
//}
      

        $this->fc->setBody($this->output);
    }

}