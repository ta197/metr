<?php
namespace application\controllers;

//use application\models\View;

class NotFoundException extends \Exception
{

    public function __construct( $message ='', $code = '404')
    {
        parent::__construct($message, $code);
        $this->error = $e;
    }

    // public function err404($e, $route)
    // {
    //     $this->fc = FrontController::getInstance();
    //     $this->route = $route;
    //     $this->file_view = $route['action'];
       
    //    $this->view = new View($this->route);
    //    $output = header("HTTP/1.0 404 Not Found");
    //    $this->view->title = '404';
    //    $this->view->h1 = 'Ошибка 404';
    //    $this->view->error = $e->message;
    //    $this->view->modul = $route['modul'];

    //     switch($this->view->modul):
    //         case 'admin':  
    //             $this->file_layout = 'admin';
    //             break;
    //         case 'petrova':  
    //             $this->file_layout = 'petrova';
    //             break;
    //         case 'metr':  
    //             $this->view->route['controller'] ='err';
    //             break;    
    //         default: 
    //            $this->file_layout = DEFAULT_ERR;
    //            $this->view->route['controller'] ='err';
    //     endswitch;

    //     $this->view->file_view = 'err404';
    //     $this->view->file_layout =  $this->file_layout;
    //     $output .= $this->view->render();
    //     $this->fc->setBody($output);
    // }


    // public function getErrorObject()
    // {
    //     return $this->error;
    // }

}
