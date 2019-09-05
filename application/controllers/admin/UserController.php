<?php
namespace application\controllers\admin;

use 
    engine\core\base\View,
    application\models\User,
    engine\core\App,  
    engine\core\IController;

class UserController extends ParentAdminController implements IController
{
    
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function indexAction()
    { 
        $this->view->users = (new User())->partAll();
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function loginAction(){
        //$this->page = null;
        if(!empty($_POST)){
            $data = $_POST;
            $user = new User();
            $user->load($data);

            if(!$user->validate($data, 'login')){
                $_SESSION['error'] = $user->getErrors();
                $this->redirect();
            }
            $newUser = $user->login(true);
            if(!$newUser){
                $user->setError('Неверный логин или пароль!');
                $_SESSION['error'] = $user->getErrors();
            }
            if(User::getSessAdminId()){
                $_SESSION['success'] = 'Вы успешно авторизованы!';
                $this->redirect('/admin');
            }else{
                $this->redirect();
            }
        }
        $this->file_layout = 'default_err';
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function logoutAction(){
        //$this->page = null;
        if(isset($_SESSION['user'])) unset($_SESSION['user']);
        if(isset($_SESSION['success'])) unset($_SESSION['success']);
        $this->redirect('/admin/user/login');
       // session_destroy();
        //header('Location: /admin/user/login');
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function usersAction(){
        $this->view->users = (new User())->partAll();
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
     public function adminsAction(){
        $this->view->users = (new User())->partAll();
    }

/////////////////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function profileAction(){
        $id = $this->checkOneParam('id');
        $user = new User();
        $this->view->user = $user
            ->where('id = ?')
            ->partObj([$id]);   
    }


/////////////////////////////////////////////////////////////////////
}
