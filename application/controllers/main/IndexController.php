<?php
namespace application\controllers\main;

use application\models\View;
use application\controllers\App, application\controllers\ParentController, application\controllers\IController;

class IndexController extends ParentController implements IController
{
  public function indexAction()
  {
    //App::$app->getList();
    $this->view->title = 'главная';
    //$this->view->file_layout = 'index';
  }
}
