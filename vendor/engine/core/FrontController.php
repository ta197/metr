<?php
namespace  engine\core;

use  engine\core\Singleton;

class FrontController
{
  use Singleton;    
  
  private $_controller, 
          $_action, 
          $_params, 
          $_body,
          $route = [];
  private  $_baseUrl; 
         
/////////////////////////////////////////////////////////////////////
 /**
  *  
  */    
  final private function __construct()
  { 
    $this->splits = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
    $this->splits = $this->shiftPrefix($this->splits);
   //$this->_baseUrl = $this->route['prefix'];  
    if(!empty($this->splits[0])){
      $this->_controller = '\application\controllers\\'. "{$this->route['modul']}". '\\'.$this->upperCamelCase($this->splits[0]).'Controller';
      $this->route['controller'] = $this->splits[0];
      $this->_baseUrl .=  '/'.$this->route['controller'];
    }else{
      $this->_controller = '\application\controllers\\'. "{$this->route['modul']}". '\IndexController';
      $this->route['controller'] = 'index';
    }
    
    if(!empty($this->splits[1])){
      $this->_action = $this->lowerCamelCase($this->splits[1]).'Action';
      $this->route['action'] = $this->splits[1];
     $this->_baseUrl .= '/'. $this->route['action'];
    }else{
      $this->_action = 'indexAction';
      $this->route['action'] = "index_{$this->route['controller']}";
      if(!empty($this->splits[2])){
        $this->_baseUrl .= '/index';
      }
    }
    //$this->route['base_url'] = $this->_baseUrl;
    $this->route['base_url'] = !empty($this->_baseUrl) ? $this->_baseUrl : '/';
 }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  private function shiftPrefix($splits)
  {
    if(!in_array($splits[0], PREFIX)){
      $this->route['modul'] = 'main';
      $prefix = '';
    }else{
      $this->route['modul'] = array_shift ($splits);
      $prefix = '/'.$this->route['modul'];
    }
    $this->route['prefix'] = $prefix.'/';
    $this->_baseUrl = $prefix;
    return $splits;

  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function checkParams()
  {
    $cnt = count($this->splits);
    if($cnt % 2 !== 0 and $cnt!==1){
      throw new \Exception("Нечетный splits", 404);
    }
    if(!empty($this->splits[2])){
      $keys = $values = [];
        for($i=2,  $cnt; $i<$cnt; $i++){
          if($i % 2 == 0){
            //Чётное = ключ (параметр)
            $keys[] = $this->splits[$i];
          }else{
            //Значение параметра;
            $values[] = $this->splits[$i];
          }
        }
        $this->_params = array_combine($keys, $values);
    }
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */      
  public function route() {
    if(class_exists($this->getController())) {
      $rc = new \ReflectionClass($this->getController());
      if($rc->implementsInterface('engine\\core\\'.'IController')) {
        if($rc->hasMethod($this->getAction())) {
          $method = $rc->getMethod($this->getAction());
          $controller = $rc->newInstance($this);
          $method->invoke($controller);
          $controller->runView();
         
        } else {
          throw new \Exception("Нет action  $this->_action", '404');
        }
      } else {
        throw new \Exception("Interface", 404);
      }
    } else {
      throw new \Exception("Нет контроллера {$this->route['controller']}", 404);
    }
  }

/////////////////////////////////////////////////////////////////////
 /**
  * преобразует имена к виду CamelCase
  * @param string $name строка для преобразования
  * @return string
  */
  protected function upperCamelCase($name) 
  {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
  }

/////////////////////////////////////////////////////////////////////
  /**
  * преобразует имена к виду camelCase
  * @param string $name строка для преобразования
  * @return string
  */
  protected function lowerCamelCase($name) 
  {
    return lcfirst($this->upperCamelCase($name));
  }
  
  
/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function __get($prop){
    switch($prop):
      case 'modul': return $this->route['modul'];
      case 'route': return $this->route;
      default:
      //return $this->route;
        throw new \Exception('Неизвестное свойство!');
    endswitch;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function getParams() {
    return $this->_params;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function getBaseUrl() {
    return $this->_baseUrl;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function getController() {
    return $this->_controller;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function getAction() {
    return $this->_action;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function getBody() {
    return $this->_body;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function setBody($body) {
    $this->_body = $body;
  }

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}	