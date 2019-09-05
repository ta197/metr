<?php
namespace application\controllers\main;

use engine\core\base\View, engine\core\Page, engine\core\Menu;
use engine\core\App,  engine\core\IController;

class IndexController extends ParentController implements IController
{
  public $file_layout = 'index';

  public function indexAction()
  {
    
    $this->view->page
      ->setScripts(['typing_carousel']);
  }


}
