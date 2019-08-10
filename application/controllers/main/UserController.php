<?php
namespace application\controllers\main;
use application\models\View; 
use application\models\User; 
use  vendor\engine\core\App,  vendor\engine\core\IController;

class UserController extends ParentController implements IController
{

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
            if($user->validate($data)){
                echo 'ok';
            }else{
                echo 'no';
            }
          //  var_dump ($_POST);
           // var_dump ($user);
            die;
        }
        $this->view->title = 'Регистрация';
        $this->view->h1 = 'Регистрация'; 

    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function loginAction(){
        $this->view->title = 'авторизация';
        $this->view->h1 = 'Авторизация';
    }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */    
    public function logoutAction(){

    }


  

/////////////////////////////////////////////////////////////////////
}
