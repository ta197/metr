<?php
namespace application\controllers;

use application\models\View, application\models\Company, application\models\Address, application\models\FiltersHandler, application\models\ParseFilters;

class PetrovaController extends ParentController implements IController
{
    public $file_layout = 'petrova';
    
    public function indexAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'IndexRezumeActiv', 'IndexRezumeDisabled');
        $this->view->title = 'Резюме Петровой Т. В.';
    }

//////////////////////////////////////////////////////////////////////

    public function developAction()
    {
        try{
            if(null !== ($this->fc->getParams())){
                if(isset($this->fc->getParams()["example"])){
                    $id = $this->fc->getParams()["example"];
                    switch($id):
                      case 'metr': 
                         $this->view->title = 'резюме | пример';
                         $this->file_view = 'metr';
                         break;
                      default: 
                         throw new AppException(" name !metr");
                  endswitch;
                  }else{
                    throw new AppException(" name !example");
                  }
            }else{
                $this->view->title = 'резюме | разработка';
            }

        }catch(AppException $e){
            $e->err404($e, $this->fc->route);
        }
    }
    
    public function designAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'DesignActiv', 'DesignDisabled');
        $this->view->title = 'резюме | дизайн';
    }

    public function proofsAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'ProofsActiv', 'ProofsDisabled');
        $this->view->title = 'резюме | корректор';
    }

//////////////////////////////////////////////////////////////////////

    public function educationAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'EducationActiv', 'EducationDisabled');
        $this->view->title = 'резюме | образование';
    }

    public function experienceAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'ExperienceActiv', 'ExperienceDisabled');
        $this->view->title = 'резюме | опыт работы';
    }
    public function addAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'AddActiv', 'AddDisabled');
        $this->view->title = 'резюме | дополнительно';
    }

 //////////////////////////////////////////////////////////////////////

}
