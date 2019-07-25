<?php
namespace application\controllers;

use application\models\View;

class IndexController extends ParentController implements IController
{
  public function indexAction()
  {
    $this->view->title = 'главная';
    $this->view->file_layout = 'index';
  }
}
