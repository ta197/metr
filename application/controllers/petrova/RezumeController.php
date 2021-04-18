<?php
namespace application\controllers\petrova;

use application\models\Certificate;
use  engine\core\App,  engine\core\IController;
use engine\core\Page;

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
	    $cert = new Certificate();
	    $this->view->bitrix = $cert->fields()->where('category_code= ?')->order_by('sort')->select()->fetchAll(['bitrix']);
	    $this->view->english = $cert->fields()->where('category_code= ?')->order_by('sort')->select()->fetchAll(['english']);
	    $this->view->retraining = $cert->fields()->where('category_code= ?')->order_by('sort')->select()->fetchAll(['retraining']);
    }

//////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////

    public function certificateAction()
    {
	    if(null !== ($this->fc->getParams())) {
		    if(isset($this->fc->getParams()["id"])) {
			    $id = $this->fc->getParams()['id'];
			    $certObj = (new Certificate())->getObjById($id);
			    $this->view->certObj = $certObj;
			
			    $this->view->page
				    ->setTitle(
					    $this->view->title . ' | ' . $this->view->certObj->type . ' ' . $this->view->certObj->name
				    );
			    $this->view->page->setHeaderTitle($this->view->certObj->name);
			    $this->view->page->setSubHeaderTitle($this->view->certObj->type);
		    } else{
			    throw new \Exception("Нет такого документа!", 404);
		    }
	    } else {
		    $certObj = (new Certificate())->getObjById(1);
		    $this->view->certObj = $certObj;
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
