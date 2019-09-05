<?php
namespace application\controllers\petrova;

use  engine\core\App,  engine\core\IController;

class RezumeController extends ParentPetrovaController implements IController
{

//////////////////////////////////////////////////////////////////////    
    public function indexAction()
    {
        $this->file_view = '../index/index_index';
    }

//////////////////////////////////////////////////////////////////////

    public function developAction()
    {
        if(null !== ($this->fc->getParams())){
            if(isset($this->fc->getParams()["example"])){
                $id = $this->fc->getParams()["example"];
                switch($id):
                    case 'metr': 
                        $this->view->page 
                            ->setTitle(BASE_TITLE.' | пример');
                        $this->file_view = 'metr';
                        break;
                    default: 
                        throw new \Exception(" name !metr", 404);
                endswitch;
                }else{
                    throw new \Exception(" name !example", 404);
                }
        }
    }

//////////////////////////////////////////////////////////////////////    
    public function designAction()
    {

    }

//////////////////////////////////////////////////////////////////////
    public function proofsAction()
    {
        
    }

//////////////////////////////////////////////////////////////////////

    public function educationAction()
    {
        if(isset($this->fc->getParams()["certificate"])){
            $id = $this->fc->getParams()["certificate"];
            $this->view->page 
                ->setTitle($this->view->title.' | сертификат')
                ->setHeaderTitle('Сертификат');
            $this->file_view = 'certificate';

            switch($id){
                case 'english':  
                    $this->view->page->setSubHeaderTitle('по английскому');
                break;
            default:   $this->view->page->setSubHeaderTitle('');
          }
        }
    }

//////////////////////////////////////////////////////////////////////
    
    public function experienceAction()
    {
        
    }

//////////////////////////////////////////////////////////////////////

    public function addAction()
    {
       
    }

 //////////////////////////////////////////////////////////////////////

}
