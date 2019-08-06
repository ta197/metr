<?php
namespace application\controllers;

use application\models\View;

class ErrorHandler
{
    protected $error;
    public $route;
    public $file_layout = LAYOUT_DEFAULT_FILE;
    public $view;
    public $fc;
    public $file_view;
    public $output;

    public function __construct()
    {
        if(DEBUG){
            error_reporting(-1);
        }else{
            error_reporting(0);
        }
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline){
        $this->logErrors("error $errno", $errstr, $errfile, $errline);
        if(DEBUG || in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR])){
            $this->displayError('error', $errno, $errstr, $errfile, $errline);
        }
        return true;
    }

    public function exceptionHandler($e){
        $this->logErrors('исключение', $e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('исключение',  $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(),  $e->getCode());
    }

    public function fatalErrorHandler(){
        $error = error_get_last();
        if(!empty($error) && $error['type']&(E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CODE_ERROR)){
            $this->logErrors("Fatal {$error[type]}", $error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayError('Fatal', $error['type'], $error['message'], $error['file'], $error['line']);
        }else{
            ob_end_flush();
           // exit;
        }
    }

    protected function logErrors($type ='', $message = '', $file = '', $line = ''){
        
            error_log("[" . date('Y-m-d H:i:s') ."]\r\nВид ошибки: $type \r\nТекст ошибки: $message \r\nФайл: $file \r\nСтрока: $line \r\n====================================\r\n\r\n ", 3, 'tmp/errors.log');
            
    }

    protected function displayError($error, $errno, $errstr, $errfile, $errline, $response = 500){
        $this->fc = FrontController::getInstance();
        $this->route =  $this->fc->route;
        $this->view = new View($this->route);

        

        $this->view->error = $error;
        $this->view->errno = $errno;
        $this->view->errstr = $errstr;
        $this->view->errfile = $errfile;
        $this->view->errline = $errline;
        $this->view->response = $response;

        //$this->view->findLayoutByModul();
        if($this->route['modul'] !== 'main'){
            $this->file_layout = $this->route['modul'];
        }elseif($this->route['modul'] === 'main' && $errstr === 'Нет контроллера  ' .$this->route['controller']){
            $this->file_layout = DEFAULT_ERR;
            $this->view->route['modul'] = 'err';
        }
        $this->view->route['controller'] ='err';
        $this->view->file_layout = $this->file_layout;
        
        if($response == 404){
            http_response_code(404);
            $this->view->title = '404';
            $this->view->h1 = 'Ошибка 404';
            if(DEBUG){
                $this->view->file_view = 'err404_dev';
            }else{
                $this->view->file_view = 'err404_prod';
            }
        }elseif($response == 500){
            http_response_code(500);
            $this->view->title = '500';
            $this->view->h1 = 'Ошибка 500';
            if(DEBUG==1){
                $this->view->file_view = 'err500_dev';
            }else{
                $this->view->file_view = 'err500_prod';
            }
        }else{
            http_response_code(500);
            $this->view->title = 'Ошибка';
            $this->view->h1 = 'Ошибка';
            if(DEBUG==1){
                $this->view->file_view = 'err500_dev';
            }else{
                $this->view->file_view = 'err500_prod';
            }
        }
        $this->fc->setBody($this->view->render());
        die;
    }

}
