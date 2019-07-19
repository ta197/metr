<?php
namespace application\controllers;

use application\models\View;

class IndexController extends ParentController implements IController
{
  public function indexAction()
  {
    $this->view->title = 'главная';
    $output = $this->view->render(DEFAULT_FILE);
    $this->fc->setBody($output);
  }
}
