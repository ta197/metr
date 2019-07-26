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

}