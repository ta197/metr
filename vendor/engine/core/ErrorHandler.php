<?php
namespace  engine\core;

use engine\core\ErrorController; 
   
class ErrorHandler
{
    protected $error;
    //public $sessUserId;

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function __construct()
    {
        if(DEBUG){
            error_reporting(-1);
        }else{
            error_reporting(0);
        }

        set_error_handler([$this, 'errorHandler']);
        ob_start();

       // $this->sessUserId = User::getSessUserId() ?? false;
            //if($this->sessUserId)
              //  $sessAdminId = User::getSessAdminId() ?? false;

        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function errorHandler($errno, $errstr, $errfile, $errline){
        $this->logErrors("error $errno", $errstr, $errfile, $errline);
        //ob_end_clean();
        if(DEBUG || in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR])){
            $this->displayError('error', $errno, $errstr, $errfile, $errline);
        }
      return true;
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function exceptionHandler($e){
        $this->logErrors('исключение', 
                            $e->getCode().' | '.$e->getMessage(), 
                            $e->getFile(), 
                            $e->getLine());
        ob_end_clean();
        $this->displayError('исключение',  
                            $e->getCode(), 
                            $e->getMessage(), 
                            $e->getFile(), 
                            $e->getLine(). " \r\n\r\n<br/><br/>Стек:<br/>" 
                                        .$e->getTraceAsString(),  
                            $e->getCode());
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function fatalErrorHandler(){
        $error = error_get_last();
        if(!empty($error) && $error['type'] && (E_ERROR || E_PARSE || E_COMPILE_ERROR || E_CODE_ERROR)){
            $this->logErrors("Fatal {$error['type']}", 
                                $error['message'], 
                                $error['file'], 
                                $error['line']);
            ob_end_clean();
            $this->displayError('Fatal', 
                                $error['type'], 
                                $error['message'], 
                                $error['file'], 
                                $error['line']);
        }else{
            ob_end_flush();
           exit;
        }
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    protected function logErrors($type ='', $message = '', $file = '', $line = ''){
        
            error_log("[" . date('Y-m-d H:i:s') ."]\r\n
                Вид ошибки: $type \r\n
                Текст ошибки: $message \r\n
                Файл: $file \r\n
                Строка: $line \r\n====================================\r\n\r\n ", 
            3, ROOT.'/tmp/errors.log');
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function displayError($error, $errno, $errstr, $errfile, $errline, $response = 500){
      
        $this->error = func_get_args();
         
        if( empty( $this->error[5]) ){
            $this->error[5] = 500;
        }
        new ErrorController( $this->error);
   //var_dump($response); die();
    }
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}
