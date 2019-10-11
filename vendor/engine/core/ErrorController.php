<?php
namespace  engine\core;

use engine\core\base\View, 
    application\controllers\admin\ParentAdminController,
    application\controllers\main\ParentController, 
    application\controllers\petrova\ParentPetrovaController,  
    engine\core\Page, 
    engine\core\Menu;

class ErrorController
{
    public $error;
    public $route;
    public $file_layout =  DEFAULT_ERR;
    public $view;
    public $fc;
    public $file_view;
    public $page;
    public $contr;
    static $c;
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function __construct($error)
    {
        if (ob_get_length() >0){
            ob_end_clean();
        }
     
        $this->error = $error;
        $this->fc = FrontController::getInstance();
        $this->route =  $this->fc->route;
        $this->layout();
        $this->checkModul();

        $this->contr = $this->controller();
       
        $this->contr->view->route['controller'] 
            = $this->contr->route['controller'] 
            = $this->route['controller'] 
            ='err';

        $this->error($this->error);

        $this->viewPage($this->error[5]);
        $this->contr->menu();

        $this->contr->view->file_layout =  $this->file_layout;
        $this->contr->view->file_view =  $this->file_view;
       
       $this->render();
    }
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function controller(){
       
        $errClass = 'Parent'.ucfirst($this->route['modul']). 'Controller';
        switch($errClass):
            case 'ParentAdminController': 
                $contr = new ParentAdminController($this->fc);
            case 'ParentPetrovaController': 
                $contr = new ParentPetrovaController($this->fc);
            default: 
                $contr = new ParentController($this->fc);
        endswitch;
        return $contr;
    }

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function layout(){
        if($this->route['modul'] !== 'main'){
            $this->file_layout = $this->route['modul'];
        }
        if($this->route['modul'] === 'main' && $this->error[2] !== "Нет контроллера {$this->route['controller']}"){
            $this->file_layout = LAYOUT_DEFAULT_FILE;
        }    
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function checkModul(){
        if($this->route['modul'] === 'main' && $this->error[2] == "Нет контроллера {$this->route['controller']}"){
            $this->route['modul'] = 'err';
        }
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function error($error){
        $this->contr->view->error = $error[0];
        $this->contr->view->errno = $error[1];
        $this->contr->view->errstr = $error[2];
        $this->contr->view->errfile = $error[3];
        $this->contr->view->errline = $error[4];
        $this->contr->view->response = $error[5];
    }

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function viewPage($response){
        $response = (int)$response;
        if($response === 404){
            $this->err404();
        }elseif($response === 500){
            $this->err500();
        }else{
            $this->errUnknow();
        }
    }

/////////////////////////////////////////////////////////////////////

    public function err404(){
        http_response_code(404);
        $this->page([$this->route['modul']."/err/404"]);
        if(DEBUG ==1){
            $this->file_view = 'err404_dev';
        }else{
            $this->file_view = 'err404_prod';
        }
    }

/////////////////////////////////////////////////////////////////////

    public function err500(){
        http_response_code(500);
        $this->page([$this->route['modul']."/err/500"]);
        if(DEBUG==1){
            $this->file_view = 'err500_dev';
        }else{
            $this->file_view = 'err500_prod';
        }
    }

/////////////////////////////////////////////////////////////////////

    public function errUnknow(){
        http_response_code(500);
        $this->page(["err/err/err"]);
        if(DEBUG==1){
            $this->file_view = 'err500_dev';
        }else{
            $this->file_view = 'err500_prod';

        }
    }

/////////////////////////////////////////////////////////////////////

    public function page($base_url){
        $this->contr->view->page = (new Page())
                    ->where("`url`= ?")
                    ->select()
                    ->fetchObject($base_url);
    }

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function render(){
        //var_dump($this->contr->view->render());
        //$this->fc->setBody($this->contr->view->render());
        $output = $this->contr->view->render();
        echo $output;
        //$this->fc->setBody($output);
        exit;
    }

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function before(){
        
    }
/////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////
}
