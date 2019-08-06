<?php
namespace application\controllers\petrova;

use application\controllers\App, application\controllers\ParentController, application\controllers\IController;

class IndexController extends ParentController implements IController
{
    public $file_layout = 'petrova';
    
    public function indexAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'IndexRezumeActiv', 'IndexRezumeDisabled');
        $this->view->title = 'Резюме Петровой Т. В.';
    }

//////////////////////////////////////////////////////////////////////


}
