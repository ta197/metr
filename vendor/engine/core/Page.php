<?php
namespace engine\core;

use engine\core\db\DB, engine\core\base\Model;

	class Page extends Model
	{
        static public $table = 'pages';
        static public $pk = 'url';
        static public $sql;         // sql-запрос
        public $base_title;		// базовый заголовок страницы
        public $title ='';		// заголовок страницы
        public $header_title ='';		// h1 страницы
        public $subh1 ='';		// подзаголовок страницы
        //protected $content;		// содержание страницы
        //protected $needLogin;	// необходима ли авторизация
        //protected $user;		// авторизованный пользователь || null
        public $keywords = '';		
        public $description = '';		
        public $url = '';
        //public $left_menu;
        public $styles = [];
        public $scripts = [];	
        public $adminlink = false; // ссылка на админку для залогиненых	
        public $err = null;
        //static public $coreProps = ['id_page', 'title', 'h1', 'keywords', 'description', 'title_in_menu'];


/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function getByUrl()
    {
        static::$sql = 'SELECT * FROM '.self::$table. ' WHERE `url` = ?';
        return $this;
    }
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function titles($base_title)
    {
        $this->base_title = $base_title;
        $this->title();
        $this->headerTitle(); 
        $this->subHeaderTitle();
        return $this;
    }
///////////////////////////////////////////////////////////////////// 
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function title()
    {
        $this->title = !empty($this->title) ? ' | ' .$this->title : '';
        $this->title = $this->base_title . $this->title;
        return $this;
    }
///////////////////////////////////////////////////////////////////// 
    /**
     *  
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }     
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function plusTitle($title)
    {
        $this->title .= ' ' .$title;
        return $this;
    }
 
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function headerTitle()
    {
        $this->header_title = !empty($this->header_title) ? $this->header_title : '';
        return $this;
    }     

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function setHeaderTitle($header_title)
    {
        $this->header_title = $header_title;
        return $this;
    }     
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function plusHeaderTitle($header_title)
    {
        $this->header_title .= ' ' .$header_title;
        return $this;
    }     
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function subHeaderTitle()
    {
        $this->subh1 = !empty($this->subh1) ? $this->subh1 : '';
        return $this;
    }     

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function setSubHeaderTitle($subh1)
    {
        $this->subh1 = $subh1;
        return $this;
     }     

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function plusSubHeaderTitle($subh1)
    {
        $this->subh1 .= ' ' .$subh1;
        return $this;
    }     
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function setBaseTitle($base_title)
    {
        $this->base_title = $base_title;
        return $this;
    }     

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function setStyles($styles)
    {
        $this->styles = array_merge( $this->styles, $styles);
        return $this;
    }     
///////////////////////////////////////////////////////////////////// 
/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     *  
     */
    public function setScripts($scripts)
    {
        $this->scripts = array_merge( $this->scripts, $scripts);
        return $this;
    }     
/////////////////////////////////////////////////////////////////////       
/////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////
}