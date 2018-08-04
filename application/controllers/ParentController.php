<?php
namespace application\controllers;

use application\models\View;

class ParentController
{
    protected $view;

    public function __construct(){
        $this->view = new View();
    }
}