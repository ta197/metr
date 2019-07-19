<?php
namespace application\controllers;

use application\models\View;

class AppException extends \Exception
{
    private $error;
    protected $view;

    public function __construct( $e)
    {
        parent::__construct($e);
        $this->error = $e;
       
    }

    public function err404($e, $modul)
    {
        $fc = FrontController::getInstance(); 
        $view = new View();
        $output = header("HTTP/1.0 404 Not Found");
        $view->error = $e->message;
        $view->modul = $modul;

        switch($modul):
            case 'admin':  $output .= $view->render(ADMIN_ERR404_FILE); break;
            case 'petrova':  $output .= $view->render(PETROVA_ERR404_FILE); break;
            default: $output .= $view->render(ERR404_FILE);
        endswitch;

        $fc->setBody($output);
    }


    public function getErrorObject()
    {
        return $this->error;
    }

}
