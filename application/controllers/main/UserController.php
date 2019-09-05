<?php
namespace application\controllers\main;

use engine\core\base\View; 
use application\models\User; 
use  engine\core\App,  engine\core\IController;

class UserController extends ParentController implements IController
{

    public function __construct($fc){
        parent::__construct($fc);
        //H::db($this->route,1);
        if(!$this->view->sessUserId && ($this->route['action'] != 'login') && ($this->route['action'] != 'signup')){
            $this->redirect('/user/login');
        }
    }


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
    public function signupAction()
    {
        if(!empty($_POST)){
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if(!$user->validate($data, 'signup') || !$user->checkUnique()){
                $_SESSION['error'] = $user->getErrors();
                $_SESSION['form-data'] = $data;
                $this->redirect();
            }
            $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            
            if($user->save()){
                $_SESSION['success'] = 'Вы успешно зарегистрированы!';
                unset ($_SESSION['form-data']);
            }else{
                $user->setError('Ошибка! Попробуйте позже!');
                $_SESSION['error'] = $user->getErrors();
            }
            $this->redirect();
        }
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function loginAction()
    {
        //$this->page = null;
        if(!empty($_POST)){
            $user = new User();
            $data = $_POST;
            $user->load($data);

            if(!$user->validate($data, 'login')){
                $_SESSION['error'] = $user->getErrors();
                $this->redirect();
            }
            $newUser = $user->login();
            if($newUser){
                $_SESSION['success'] = 'Вы успешно авторизованы!';
                if($newUser->role == 'user'){
                    $this->redirect('/user/profile/id/'.$newUser->id);
                }
                if($newUser->role== 'admin'){
                    $this->redirect('/admin/user/profile/id/'.$newUser->id);
                }
               
            }else{
                $user->setError('Неверный логин или пароль!');
                $_SESSION['error'] = $user->getErrors();
                $this->redirect();
            }
        }
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function logoutAction(){
        //$this->page = null;
        if(isset($_SESSION['user'])) unset($_SESSION['user']);
        if(isset($_SESSION['success'])) unset($_SESSION['success']);
        $this->redirect($this->route['prefix'].'user/login');
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function profileAction(){
        $id = $this->checkOneParam('id');
        if($this->view->sessUserId != $id){
           throw new \Exception("У вас нет права просмотра этой страницы", 404);
        }  
       
        $this->view->user = (new User())
            ->where('id = ?')
            ->partObj([$id]);

        $this->view->page
            ->plusHeaderTitle($this->view->user->name);
    }


  

/////////////////////////////////////////////////////////////////////
}
