<?php
namespace application\controllers\admin;

use engine\core\base\View, 
    engine\core\ErrorHandler, 
    application\controllers\admin\ParentAdminController,  
    application\models\User, 
    engine\core\Page, 
    engine\core\Menu, 
    engine\core\db\DB, 
    engine\core\base\Model;

class ErrorAdminController extends ParentAdminController
{
    public $error;
    public $route;
    public $file_layout =  DEFAULT_ERR;
    public $view;
    public $fc;
    public $file_view;
    public $output;
    public $sessUserId;
    public $page;

    public function __construct($fc, $route, $file_layout,  $error, $errno, $errstr, $errfile, $errline, $response)
    {
        
        $this->fc = $fc;
        $this->route =  $route;
        $this->view = new View($this->route);
        //$this->isRole();
        $this->view->error = $error;
        $this->view->errno = $errno;
        $this->view->errstr = $errstr;
        $this->view->errfile = $errfile;
        $this->view->errline = $errline;
        $this->view->response = (int)$response;

        $this->view->route['controller'] ='err';
       
       
        if($response === 404){
            //http_response_code(404);
            //$this->page([$this->route['modul']."/err/404"]);
            $this->err404();
                
        }elseif($response === 500){
           // http_response_code(500);
           // $this->page = $page->fetchObject([$this->route['modul']."/err/500"]);
            $this->err500();
            
        }else{
            //http_response_code(500);
            //$this->page = $page->fetchObject(["err/err/err"]);
            $this->errUnknow();
            
        }

        $this->view->file_layout =  $file_layout;
        
        
        $this->view->page = $this->page;
        $this->view->file_view =  $this->file_view;
        if(isset($this->view->page->id_page) ){
            $this->view->nav = (new Menu())->navSimple($this->view->page->id_page);
        }
//return $this->view;
        //$this->b($this, 1);
       $this->fc->setBody($this->view->render());
    exit;
    }

    public function err404(){
        //http_response_code(404);
        $this->page([$this->route['modul']."/err/404"]);
        if(DEBUG ==1){
            $this->file_view = 'err404_dev';
        }else{
            $this->file_view = 'err404_prod';
        }
    }

    public function err500(){
        //http_response_code(500);
        $this->page([$this->route['modul']."/err/500"]);
        if(DEBUG==1){
            $this->file_view = 'err500_dev';
        }else{
            $this->file_view = 'err500_prod';
        }
    }

    public function errUnknow(){
        //http_response_code(500);
        $this->page(["err/err/err"]);
        if(DEBUG==1){
            $this->file_view = 'err500_dev';
        }else{
            $this->file_view = 'err500_prod';

        }
    }

    public function page($base_url){
        $this->page = (new Page())
                    ->where("`url`= ?")
                    ->select()
                    ->fetchObject($base_url);
    }

    public function modul(){
        
    }

    public function menu(){
        
    }
    
    public function render(){
       $this->fc->setBody($this->view->render());
        exit;
    }

}
