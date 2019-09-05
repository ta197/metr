<?php
namespace application\models;
use  engine\core\db\DB, engine\core\base\Model;

class User extends Model
{
    static public $pk = 'id';
    static public $table = 'user';
    static public $sql;

    public $attributes = [
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'role' => 'user'
    ];

    protected $rules = [
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

    static public $coreProps = ['id', 'role', 'login', 'name', 'email'];
    
/////////////////////////////////////////////////////////////////////
     /**
     * 
     */   
    // public function __construct(){
     
    // }

/////////////////////////////////////////////////////////////////////

        public function checkUnique(){
          
            $user = $this->where('login = ? OR email = ?')
                ->select()
                ->fetchObject([$this->attributes['login'],  $this->attributes['email']]) ;
    
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
            //$user = $this->findObjByWhere([$login, 'admin'], 'WHERE login = ? AND role = ?');
            $user = $this->where('login = ? AND role = ?')->select()
                    ->fetchObject([$login, 'admin']);
        }else{
            //$user = $this->findObjByField($login, 'login');
            $user = $this->where('login = ?')->select()
                        ->fetchObject([$login]);
        }
       
        if($user){
            if(password_verify($password, $user->password)){
               $user->password = null;
                foreach ($user as $key => $value) {
                    if($key !== 'password') $_SESSION['user'][$key] = $value;
                    
                }
                return $user; 
            }
        }
    }
    return false;
}
  
/////////////////////////////////////////////////////////////////////

public static function getSessUserId(){
    return $_SESSION['user']['id'] ?? false;
}

/////////////////////////////////////////////////////////////////////  

public static function getSessAdminId(){
    return ((isset($_SESSION['user'])) && $_SESSION['user']['role'] == 'admin') ? $_SESSION['user']['id'] : false;
}



/////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////
}

