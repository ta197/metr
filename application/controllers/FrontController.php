<?php
namespace application\controllers;

class FrontController
{
  private static $instance = null;
  private $_controller, 
          $_action, 
          $_params, 
          $_body, 
          $first, 
          $modul = 'metr',
          $route = [];
    
  final private function __construct(){ 
    $this->splits = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
    $this->first = $this->splits[0];
    
    
    //Какой сontroller использовать?
    $this->_controller = !empty($this->splits[0]) ? "\application\controllers\\".ucfirst($this->splits[0]).'Controller' : '\application\controllers\IndexController';
    $this->route['controller'] = !empty($this->splits[0]) ? $this->splits[0] : 'index';

    //Какой action использовать?
    $this->_action = !empty($this->splits[1]) ? $this->splits[1].'Action' : 'indexAction';
    $this->route['action'] = !empty($this->splits[1]) ? $this->splits[1]: "index_{$this->route['controller']}";
    $this->modul = $this->getModul();
    $this->route['modul'] = $this->modul;
  }

  public function checkParams(){
    $cnt = count($this->splits);
    if($cnt % 2 !== 0 and $cnt!==1){
      throw new AppException("Нечетный splits");
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

  final private function __clone() {}

  public static function getInstance(){ 
    if (null === self::$instance) 
      self::$instance = new self;
    return self::$instance;
  }
       
  public function route() {
    if(class_exists($this->getController())) {
      $rc = new \ReflectionClass($this->getController());
      if($rc->implementsInterface('application\\controllers\\'.'IController')) {
        if($rc->hasMethod($this->getAction())) {
          $controller = $rc->newInstance($this->route);
          
          $method = $rc->getMethod($this->getAction());
         
          $method->invoke($controller);
          $controller->runView();
         
        } else {
          throw new AppException("Action");
        }
      } else {
        throw new AppException("Interface");
      }
    } else {
      throw new AppException("Controller");
    }
  }

  private function getModul(){
    switch($this->route['controller']):
      case 'index': return "metr"; break;
      case 'admin': return "admin"; break;
      case 'petrova': return "petrova"; break;
      case 'company': return "metr"; break;
      case 'category': return "metr"; break;
      case 'catalog': return "metr"; break;
      case 'search': return "metr"; break;
      case 'about': return "metr"; break;
      default: return "err"; break;
    endswitch;
  }

  public function __get($prop){
    switch($prop):
      case 'modul': return $this->modul;
      case 'first': return $this->first;
      default:
      return $this->route;
        //throw new \Exception('Неизвестное свойство!');
    endswitch;
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