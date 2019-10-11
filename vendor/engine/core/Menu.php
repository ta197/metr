<?php
namespace engine\core;

use engine\core\db\DB, engine\core\base\Model;

class Menu extends Model
{
        static public $table = 'menu';
        static public $pk = 'id_menu';
        //static public $sql;         // sql-запрос
        //protected $title;
        public $table_name;
        public $menuList = [];
        //public $nav = [];
        //static public $coreProps = ['id_page', 'title', 'h1', 'keywords', 'description', 'title_in_menu'];

/////////////////////////////////////////////////////////////////////
    
/////////////////////////////////////////////////////////////////////
       /**
        * 
        */
        public function getNavSimple($menuList){
                //var_dump($menuList); die;
                $nav = [];
                foreach($menuList as $menu){
                        $nav[$menu['table_name']] =  (new Menu())
                        ->table($menu['table_name'])
                        ->select()
                        ->fetchAll();
                }
                //var_dump($nav); die;
                return  $nav;
        }
        
/////////////////////////////////////////////////////////////////////
       /**
        * SELECT * FROM `menu` JOIN menu_in_pages using (id_menu) WHERE id_page = 5;
        */
        public function getMenuList($id_page){
                $this->menuList = $this
                        ->join("menu_in_pages using (id_menu)")
                        ->where('id_page = '. $id_page)
                        ->select()
                        ->fetchAll();
                       // var_dump($this->menuList); die;
                return  $this->menuList;
        }

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
       /**
        * 
        */
        public function navSimple($id_page){
                $this->menuList = $this->getMenuList($id_page);
        return  $this->getNavSimple($this->menuList);

        }
/////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////

}