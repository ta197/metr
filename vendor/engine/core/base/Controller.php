<?php
namespace engine\core\base;

use engine\core\base\View,  application\models\User, engine\core\RouteController, engine\core\Page, engine\core\Menu;
use engine\core\FrontController;


class Controller extends RouteController
{
/////////////////////////////////////////////////////////////////////

    public $base_title = BASE_TITLE;
    //public $base_url = [];
    public $page = true;
    public $nav;

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */ 
    public function __construct($fc)
    {
        parent::__construct($fc);
        
            $this->isRole();
            $this->view->title = $this->base_title;
            $this->before();
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function isRole()
    {
        $this->view->sessUserId = User::getSessUserId() ?? false;
        if($this->view->sessUserId)
            $this->view->sessAdminId = User::getSessAdminId() ?? false;
    }

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    protected function page(){
            
        $this->page = (new Page())
            ->where("`url`= ?")->select()->fetchObject([$this->route['base_url']]);
         $this->view->page = $this->page;   
        if(!$this->page){
            $this->view->page = new Page();
            $this->view->page->err = 'Не найдена страница '. $this->route['base_url'].' в таблице page';
            } 
            
        if(is_object( $this->view->page)){
            $this->view->page->titles($this->base_title); 
        } 
    }

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function menu(){
      
        if(is_object( $this->view->page)){
            $this->view->nav = (new Menu())->navSimple($this->view->page->id_page);
        }
    }
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function before(){
        if($this->page){
           $this->page();
        }
         
           
        if(isset($this->page->id_page)){
            $this->menu();
        }
    }
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    //public function get_base_url(){
        //return [$this->route['modul'], $this->route['controller'], $this->route['action']];
    //}

/////////////////////////////////////////////////////////////////////    
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
   // public function getBaseUrl(){
        //return [$this->route['modul'], $this->route['controller'], $this->route['action']];
  //  }

///////////////////////////////////////////////////////////////////// 
/////////////////////////////////////////////////////////////////////
    /**
     *  Запрос произведен методом GET?
     */
	protected function IsGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
    }
    


/////////////////////////////////////////////////////////////////////
    /**
     *  Запрос произведен методом POST?
     */
	protected function IsPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
    

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    protected function redirect($http = false)
    {
        if($http){
            $redirect = $http;
        }else{
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/";  
        }
        header("Location: $redirect");
        exit;
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public static function b($arr, $die = false)
    {
        echo '<pre>'.print_r($arr, true).'</pre>';
        if($die) die;
     }
   
/////////////////////////////////////////////////////////////////////
   
/////////////////////////////////////////////////////////////////////
}