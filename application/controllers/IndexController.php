<?php
namespace application\controllers;

use application\models\View;

class IndexController extends ParentController implements IController
{
  public function indexAction()
  {
    $fc = FrontController::getInstance();
   // $view = new View();
    $this->view->title = 'главная';
    $output = $this->view->render(DEFAULT_FILE);
    $fc->setBody($output);
  }
}
