<?php
namespace application\controllers\petrova;

//use application\models\View, application\models\Company, application\models\Address, application\models\FiltersHandler, application\models\ParseFilters;
use application\controllers\App, application\controllers\ParentController, application\controllers\IController;

class RezumeController extends ParentController implements IController
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
        // try{
            if(null !== ($this->fc->getParams())){
                if(isset($this->fc->getParams()["example"])){
                    $id = $this->fc->getParams()["example"];
                    switch($id):
                      case 'metr': 
                         $this->view->title = 'резюме | пример';
                         $this->file_view = 'metr';
                         break;
                      default: 
                         throw new \Exception(" name !metr", 404);
                  endswitch;
                  }else{
                    throw new \Exception(" name !example", 404);
                  }
            }else{
                $this->view->title = 'резюме | разработка';
            }
            $this->view->navStatus = $this->view->navStatus(['rezume'], 'DevelopActiv', 'DevelopDisabled');
        // }catch(AppException $e){
        //     $e->err404($e, $this->fc);
        // }
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
        // try{
            if(isset($this->fc->getParams()["certificate"])){
              $id = $this->fc->getParams()["certificate"];
              $this->view->title = 'резюме | сертификат';
              $this->file_view = 'certificate';
              $this->view->h1 = 'Сертификат';
              switch($id){
                case 'english':  
                    $this->view->subh1 = 'по английскому';
                    break;
                default:  $this->view->subh1 = '';
              }
             // $this->view->subh1 = 'Сертификат';

            }else{
                $this->view->title = 'резюме | образование';
              //throw new AppException("img !name");
            }
        // }catch(AppException $e){
        // $e->err404($e, $this->fc);
        // }
      $this->view->navStatus = $this->view->navStatus(['rezume'], 'EducationActiv', 'EducationDisabled');
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
