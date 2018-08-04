<?php
namespace application\controllers;

use application\models\Singleton;

class FrontController
{
  use Singleton;
  
  protected $_controller, $_action, $_params, $_body;
  private static $instance;
    
  private function __construct()
  {
    $request = $_SERVER['REQUEST_URI'];
    $splits = explode('/', trim($request,'/'));
    //Какой сontroller использовать?
    $this->_controller = !empty($splits[0]) ? "\application\controllers\\".ucfirst($splits[0]).'Controller' : '\application\controllers\IndexController';
    //Какой action использовать?
    $this->_action = !empty($splits[1]) ? $splits[1].'Action' : 'indexAction';
    //Есть ли параметры и их значения?
    if(!empty($splits[2])){
      $keys = $values = [];
      for($i=2, $cnt = count($splits); $i<$cnt; $i++){
        if($i % 2 == 0){
          //Чётное = ключ (параметр)
          $keys[] = $splits[$i];
        }else{
          //Значение параметра;
          $values[] = $splits[$i];
        }
      }
      $this->_params = array_combine($keys, $values);
    }
  }
       
  public function route() {
    if(class_exists($this->getController())) {
      $rc = new \ReflectionClass($this->getController());
      if($rc->implementsInterface('application\\controllers\\'.'IController')) {
        if($rc->hasMethod($this->getAction())) {
          $controller = $rc->newInstance();
          $method = $rc->getMethod($this->getAction());
          $method->invoke($controller);
        } else {
          throw new Exception("Action");
        }
      } else {
        throw new Exception("Interface");
      }
    } else {
      throw new Exception("Controller");
    }
  }
  public function getParams() {
    return $this->_params;
  }
  public function getController() {
    return $this->_controller;
  }
  public function getAction() {
    return $this->_action;
  }
  public function getBody() {
    return $this->_body;
  }
  public function setBody($body) {
    $this->_body = $body;
  }
}	