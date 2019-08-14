<?php
namespace application\models;
use  engine\core\base\DB, engine\core\Model;

class User extends Model
{
    protected $pk = 'id';
    public static $table = 'user';

    public $attributes = [
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'role' => 'user'
    ];

    public $rules = [
        'signup' => [
            'required' => [
                ['login'],
                ['password'],
                ['email'],
                ['name'],
            ],
            'email' => [
                ['email'],
            ],
            'lengthMin' => [
                ['password', 6],
            ]
        ],
        'login' =>[
            'required' => [
                ['login'],
                ['password'],
            ],
            'lengthMin' => [
                ['password', 6],
            ] 
        ]
    ];
    
/////////////////////////////////////////////////////////////////////
     /**
     * 
     */   
    //public function __construct(){
        
    //}

/////////////////////////////////////////////////////////////////////

        public function checkUnique(){
            $user = $this->findObjByWhere([$this->attributes['login'],  $this->attributes['email']], 'WHERE login = ? OR email = ?');
            //var_dump($user); die;
            if($user){
                if($user->login == $this->attributes['login']){
                    $this->errors['unique'][] = 'Этот логин уже занят';
                }
                if($user->email == $this->attributes['email']){
                    $this->errors['unique'][] = 'Этот email уже занят';
                }
                return false;
            }
            return true;
        }

/////////////////////////////////////////////////////////////////////

public function save(){
    $sql  = "INSERT INTO `user`(login, password, name, email, role) VALUES (?, ?, ?, ?, ?)";
    $user = DB::prepare($sql)->execute([$this->attributes['login'], $this->attributes['password'], $this->attributes['name'], $this->attributes['email'], $this->attributes['role']]);
    return $id  = DB::lastInsertId();
}
  
/////////////////////////////////////////////////////////////////////

public function login(bool $isAdmin = false){
    $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
    $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;
   
    if($login && $password){
        if($isAdmin){
            $user = $this->findObjByWhere([$login, 'admin'], 'WHERE login = ? AND role = ?');
        }else{
            $user = $this->findObjByField($login, 'login');
        }
       
        if($user){
            if(password_verify($password, $user->password)){
                foreach ($user as $key => $value) {
                    if($key !== 'password') $_SESSION['user'][$key] = $value;
                }
                return true;; 
            }
        }
    }
    return false;
}
  
   
/////////////////////////////////////////////////////////////////////

public static function isAdmin(){
    return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
}

/////////////////////////////////////////////////////////////////////

public static function getUsersAll(){
    $sql  = "SELECT * FROM user ORDER BY id DESC";
    return $data = DB::prepare($sql)->execute()->fetchAll();
}  

/////////////////////////////////////////////////////////////////////
}

