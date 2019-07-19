<?php
namespace application\controllers;

use application\models\View, application\models\Company, application\models\Address, application\models\FiltersHandler, application\models\ParseFilters;

class PetrovaController extends ParentController implements IController
{
    
    public function indexAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'IndexRezumeActiv', 'IndexRezumeDisabled');
        $output = $this->view->render(DEFAULT_PETROVA_FILE);
        $this->fc->setBody($output);
    }

//////////////////////////////////////////////////////////////////////

    public function developAction()
    {
        $id = $this->fc->getParams()["example"];
        
        switch($id):
            case 'metr': $output = $this->view->render(PETROVA_METR_FILE); break;
            default: $this->view->navStatus = $this->view->navStatus(['rezume'], 'DevelopActiv', 'DevelopDisabled'); $output = $this->view->render(PETROVA_DEVELOP_FILE); 
        endswitch;
        $this->fc->setBody($output);
    }
    
    public function designAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'DesignActiv', 'DesignDisabled');
        $output = $this->view->render(PETROVA_DESIGN_FILE);
        $this->fc->setBody($output);
    }

    public function proofsAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'ProofsActiv', 'ProofsDisabled');
        $output = $this->view->render(PETROVA_PROOFS_FILE);
        $this->fc->setBody($output);
    }

//////////////////////////////////////////////////////////////////////

    public function educationAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'EducationActiv', 'EducationDisabled');
        $output = $this->view->render(PETROVA_EDUCATION_FILE);
        $this->fc->setBody($output);
    }

    public function experienceAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'ExperienceActiv', 'ExperienceDisabled');
        $output = $this->view->render(PETROVA_EXPERIENCE_FILE);
        $this->fc->setBody($output);
    }
    public function addAction()
    {
        $this->view->navStatus = $this->view->navStatus(['rezume'], 'AddActiv', 'AddDisabled');
        $output = $this->view->render(PETROVA_ADD_FILE);
        $this->fc->setBody($output);
    }

 //////////////////////////////////////////////////////////////////////

}
