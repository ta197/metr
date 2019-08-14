<?php
namespace application\controllers\main;

use application\models\View; 
use application\models\User; 
use  engine\core\App,  engine\core\IController, engine\libs\H;

class UserController extends ParentController implements IController
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
    public function signupAction()
    {
        if(!empty($_POST)){
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if(!$user->validate($data, 'signup') || !$user->checkUnique()){
                $_SESSION['error'] = $user->getErrors();
                $_SESSION['form-data'] = $data;
                H::redirect();
            }
            $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            
            if($user->save()){
                $_SESSION['success'] = 'Вы успешно зарегистрированы!';
                unset ($_SESSION['form-data']);
            }else{
                $user->setError('Ошибка! Попробуйте позже!');
                $_SESSION['error'] = $user->getErrors();
            }
            H::redirect();
        }
        $this->view->title = 'Регистрация';
        $this->view->h1 = 'Регистрация'; 

    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function loginAction()
    {
        if(!empty($_POST)){
            $user = new User();
            $data = $_POST;
            $user->load($data);

            if(!$user->validate($data, 'login')){
                $_SESSION['error'] = $user->getErrors();
                H::redirect();
            }
            if($user->login()){
                $_SESSION['success'] = 'Вы успешно авторизованы!';
                H::redirect($this->route['prefix']);
            }else{
                $user->setError('Неверный логин или пароль!');
                $_SESSION['error'] = $user->getErrors();
                H::redirect();
            }
        }
        $this->view->title = 'авторизация';
        $this->view->h1 = 'Авторизация';

    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function logoutAction(){
        if(isset($_SESSION['user'])) unset($_SESSION['user']);
        if(isset($_SESSION['success'])) unset($_SESSION['success']);
        H::redirect($this->route['prefix'].'user/login');
    }


  

/////////////////////////////////////////////////////////////////////
}
