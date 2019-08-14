<?php
namespace application\controllers\admin;

use 
    application\models\View,
    engine\libs\H,
    application\models\User;
    
use  engine\core\App,  engine\core\IController;

class UserController extends ParentAdminController implements IController
{

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function indexAction()
    { 
        $this->view->users = User::getUsersAll();
        $this->view->navStatus = $this->view->navStatus(['admin'], 'UserActiv', 'UserDisabled'); 
        $this->view->title = 'список пользователей';
        $this->view->h1 = 'Список пользователей';    

    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function loginAction(){
        if(!empty($_POST)){
            $data = $_POST;
            $user = new User();
            $user->load($data);

            if(!$user->validate($data, 'login')){
                $_SESSION['error'] = $user->getErrors();
                H::redirect();
            }
            if(!$user->login(true)){
                $user->setError('Неверный логин или пароль!');
                $_SESSION['error'] = $user->getErrors();
            }
            if(User::isAdmin()){
                H::redirect('/admin');
            }else{
                H::redirect();
            }
            
        }
        $this->file_layout = 'default_err';
        $this->view->title = 'авторизация';
        $this->view->h1 = 'Авторизация админа';
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function logoutAction(){
        if(isset($_SESSION['user'])) unset($_SESSION['user']);
        if(isset($_SESSION['success'])) unset($_SESSION['success']);
        H::redirect('/admin/user/login');
       // session_destroy();
        //header('Location: /admin/user/login');
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function usersAction(){
        $this->view->users = User::getUsersAll();
        $this->view->navStatus = $this->view->navStatus(['admin'], 'UserActiv', 'UserDisabled'); 
        $this->view->title = 'список пользователей';
        $this->view->h1 = 'Список пользователей'; 
    }


/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
     public function adminsAction(){
        $this->view->users = User::getUsersAll(); 
        $this->view->navStatus = $this->view->navStatus(['admin'], 'UserActiv', 'UserDisabled'); 
        $this->view->title = 'список админов';
        $this->view->h1 = 'Список администраторов'; 
    }

/////////////////////////////////////////////////////////////////////
  

/////////////////////////////////////////////////////////////////////
}
