<?php
namespace application\controllers;

use application\models\View;

class AppException extends \Exception
{
    protected $error;
    public $route;
    public $file_layout = LAYOUT_DEFAULT_FILE;
    public $view;
    protected $fc;
    public $file_view;
    public $output;

    public function __construct( $e)
    {
        parent::__construct($e);
        $this->error = $e;
    }

    public function err404($e, $route)
    {
        $this->fc = FrontController::getInstance();
        $this->route = $route;
        $this->file_view = $route['action'];
       
       $this->view = new View($this->route);
       $output = header("HTTP/1.0 404 Not Found");
       $this->view->title = '404';
       $this->view->h1 = 'Ошибка 404';
       $this->error = $e->message;
       $this->view->modul = $route['modul'];

        switch($this->view->modul):
            case 'admin':  
                //$output .= $view->render(ADMIN_ERR404_FILE); 
                $this->file_layout = 'admin';
                break;
            case 'petrova':  
                $this->file_layout = 'petrova';
                break;
            case 'metr':  
                //$this->file_layout = LAYOUT_DEFAULT_FILE;
                $this->view->route['controller'] ='err';
                break;    
            default: 
               // $output .= $view->render(ERR404_FILE);
               $this->file_layout = DEFAULT_ERR;
               $this->view->route['controller'] ='err';
        endswitch;

        $this->view->file_view = 'err404';
        $this->view->file_layout =  $this->file_layout;
        //header("Location: err404", true, 404);
        $output .= $this->view->render();
        $this->fc->setBody($output);
    }


    public function getErrorObject()
    {
        return $this->error;
    }

}
