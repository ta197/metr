<?php
namespace application\controllers;

use application\models\View;

class ParentController
{
    protected $view;
    protected $fc;

    public function __construct(){
        $this->view = new View();
        $this->fc = FrontController::getInstance();
    }
}