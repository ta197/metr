<?php
namespace  engine\core;

use  engine\core\Singleton;

class FrontController
{
  use Singleton; 

  const MAP_ROUTES = MAPS.'/map_routes.php';
  
  private $_controller, 
          $_action, 
          $_params, 
          $_body;

  private $splits;

  private $route = [];

  private $order = [0=>'modul', 1=>'controller', 2=>'action'];

/**
  * таблица маршрутов
  * @var array
  */
  protected $routes = [];
         
/////////////////////////////////////////////////////////////////////
 /**
  *  
  */    
  final private function __construct()
  { 
    $url = $_SERVER['REQUEST_URI'];

    $this->routes = include_once(self::MAP_ROUTES);
    $route = $this->isCustom($this->routes, $url);
    if($route){
      $url = $this->realUrl($route);
    }
    
    $this->splits($url)
          ->prefix()->route()->baseUrl()
          ->controller()->action();
  }

/////////////////////////////////////////////////////////////////////
  /**
   * ищет URL в таблице маршрутов 
   * и если находит, возвращает массив элементов маршрута. иначе - пустой массив
   * @param array, @param string: $routes, $url  //входящий URL 
   * @return array
   */
  private function isCustom($routes, $url) 
  {
    foreach($routes as $pattern => $route){
        if(preg_match("#$pattern#i", $url, $matches)){
          foreach($matches as $k => $v){
            if(is_string($k) && !isset($route[$k])){
              $route[$k] = $v;
            }
          }
          return $route;   
        }
    }
    return [];
  }

/////////////////////////////////////////////////////////////////////
 /**
  * берет массив элементов custom-маршрута и склеивает реальный url
  * @param array $route 
  * @return string
  */
  private function realUrl($route) 
  {
    $url = '';
    foreach ($this->order as $v){
      if(array_key_exists($v, $route)){
        $url .= !empty($route[$v]) ? '/'.$route[$v] : '';
      }
    }
    foreach ($route as $key => $value) {
      if($key != 'modul' && $key != 'controller' && $key != 'action'){
        $url .= '/'.$key.'/'.$value;
      }
    }
   return $url;
  }

/////////////////////////////////////////////////////////////////////
 /**
  * @param string $url 
  * @return object
  */
  private function splits($url) 
  {
    $this->splits = explode('/', trim($url,'/'));
    return $this;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  определяет какой модуль, вырезает его из $splits
  *  @return object
  */
  private function prefix()
  {
    if(!in_array($this->splits[0], PREFIX)){
      $this->route['modul'] = 'main';
      $prefix = '';
    }else{
      $this->route['modul'] = array_shift ($this->splits);
      $prefix = '/'.$this->route['modul'];
    }
    $this->route['prefix'] = $prefix.'/';
    return $this;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  @return object
  */
  private function route() 
  {
    $this->route['controller'] = (!empty($this->splits[0]) ? $this->splits[0] : 'index');
    $this->route['action'] = (!empty($this->splits[1]) ? $this->splits[1] : "index_{$this->route['controller']}");
    return $this;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  @return object
  */
  private function baseUrl() 
  {
    $baseUrl = rtrim($this->route['prefix'], '/');  
    if(!empty($this->splits[0])){
      $baseUrl .= '/'.$this->route['controller'];
    }
    if(!empty($this->splits[1])){
     $baseUrl .= '/'. $this->route['action'];
    }else{
      if(!empty($this->splits[2])){
        $baseUrl .= '/index';
      }
    }
    $this->route['base_url'] = !empty($baseUrl) ? $baseUrl : '/';
    return $this;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  @return object
  */
  public function controller() 
  {
    $this->_controller = '\application\controllers\\'
                      . "{$this->route['modul']}"
                      . '\\'
                      .$this->upperCamelCase( $this->route['controller'])
                      .'Controller';
    return $this;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  @return object
  */
  public function action() 
  {
    $action = explode('_', $this->route['action']);
    $this->_action = $this->lowerCamelCase($action[0]).'Action';
    return $this;
  }

/////////////////////////////////////////////////////////////////////
 /**
  * добавляет маршрут в таблицу маршрутов
  * 
  * @param string $regexp регулярное выражение маршрута
  * @param array $route маршрут ([controller, action, params])
  */
  public function add($regexp, $route = []) 
  {
    $this->routes[$regexp] = $route;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *   @return void
  */      
  public function run() 
  {
    $this->checkParams();
    if(class_exists($this->getController())) {
      $rc = new \ReflectionClass($this->getController());
      if($rc->implementsInterface('engine\\core\\'.'IController')) {
        if($rc->hasMethod($this->getAction())) {
          $method = $rc->getMethod($this->getAction());
          $controller = $rc->newInstance($this);
          $method->invoke($controller);
          $controller->runView();
         
        }else{
          throw new \Exception("Нет action  $this->_action", '404');
        }
      }else{
        throw new \Exception("Interface", 404);
      }
    }else {
      throw new \Exception("Нет контроллера {$this->route['controller']}", 404);
    }
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  private function checkParams()
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
  public function __get($prop)
  {
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
  public function getParams() 
  {
    return $this->_params;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function getBaseUrl() 
  {
    return $this->_baseUrl;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function getController() 
  {
    return $this->_controller;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function getAction() 
  {
    return $this->_action;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function getBody() 
  {
    return $this->_body;
  }

/////////////////////////////////////////////////////////////////////
 /**
  *  
  */
  public function setBody($body) 
  {
    $this->_body = $body;
  }

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}	