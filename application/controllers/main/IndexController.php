<?php
namespace application\controllers\main;

use application\models\View;
use application\controllers\App,  vendor\engine\core\IController;

class IndexController extends ParentController implements IController
{
  public $file_layout = 'index';

  public function indexAction()
  {
    $this->view->title = 'главная';
  }
}
