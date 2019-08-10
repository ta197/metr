<?php
namespace application\controllers\petrova;

use  vendor\engine\core\App,  vendor\engine\core\IController;

class IndexController extends ParentPetrovaController implements IController
{
    
    public function indexAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'IndexRezumeActiv', 'IndexRezumeDisabled');
        $this->view->title = 'Резюме Петровой Т. В.';
    }

//////////////////////////////////////////////////////////////////////


}
