<?php
namespace application\base;

class DB 
{
	private static $instance = null;
    final private function __construct() {}
    final private function __clone() {}
    public static function getInstance()
    {
        if (self::$instance === null)
        {
			$opt  = [
				\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
				\PDO::ATTR_EMULATE_PREPARES   => TRUE,
				\PDO::ATTR_STATEMENT_CLASS    => array('application\base\MyPDOStatement'),
			];

			$params = parse_ini_file ('config.ini');
	
            $dsn = 'mysql:host='.$params['db.host'].';dbname='.$params['db.name'].';charset='.$params['db.charset'];
			self::$instance = new \PDO($dsn, $params['db.user'], $params['db.pass'], $opt);
			
        }
        return self::$instance;
    }
    public static function __callStatic($method, $args) {
        return call_user_func_array(array(self::getInstance(), $method), $args);
    }
}


// // with two variables and one row returned
// $sql  = "SELECT * FROM users WHERE name = ? AND password=?";
// return $data = DB::prepare($sql)->execute([$_POST['name'],$_POST['pass']])->fetch();

// echo $user['name'];

// // with one variable and single value returned
// $sql   = "SELECT count(*) FROM users WHERE age > ?";
// $count = DB::prepare($sql)->execute([$age])->fetchColumn();
//return $count;
// echo $count;

// // without variables and getting more than one rows
// $sql  = "SELECT * FROM users ORDER BY id DESC";
// return $data = DB::prepare($sql)->execute()->fetchAll();
// foreach($data as $row) {
//     echo $user['name'];
// }

// //insert with getting insert id
// $sql  = "INSERT INTO users VALUES (NULL,?,?,?)";
// $user = DB::prepare($sql)->execute([$name,$pass,$email])->fetch();
// $id   = DB::lastInsertId();



    //     $cat = DB::quote('%'.$word.'%');
    //    // echo $cat; die;
    //         $sql  = "SELECT cats.cat_id, cats.name
    //         FROM `cats` 
    //         WHERE cats.name LIKE $cat AND cats.visible = 1";
    //     return $data = DB::query($sql)->fetchAll();    