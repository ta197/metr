<?php
namespace application\controllers\admin;

use engine\core\base\View,  application\models\User, engine\core\base\Controller;
use engine\core\FrontController;

class ParentAdminController extends Controller
{
    public $file_layout = 'admin';
    public $base_title = 'админ';
   
    public function __construct($fc){
        parent::__construct($fc);
       
       
    }

    public function isRole(){
        $sessAdminId = User::getSessAdminId() ?? false;
       // $this->b($this,1);
        if(!$sessAdminId ){
            if($this->route['base_url'] != '/admin/user/login'){
                //$this->b($this->route['controller'],1);
                $this->redirect('/admin/user/login');
            }elseif(!empty($this->fc->splits[2])){
                $this->redirect('/admin/user/login');
            }
            
        }
       
        $this->view->sessAdminId = $sessAdminId;
       // $this->view->sessUserId['role'] = 'admin';
    }

}