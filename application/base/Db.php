<?php
namespace application\base;

use application\models\Singleton;

class Db
{
    use Singleton;    

    private static $dbh;
    //static $stmts = array();
    //$params = parse_ini_file ('config.ini');
    
    private function __construct()
    {
       try{
        $params = parse_ini_file ('config.ini');
        self::$dbh = new \PDO($params['db.conn'], $params['db.user'], $params['db.pass']);
            self::$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
           //$pdo = $this->pdo;
           
               //return self::$dbh;
            }
            catch (PDOException $e){
            echo "Соединения с базой нет.".$e-> getMessage();
            }
    }
    
    function prepareStatement( $stmt_s )
    {
        if ( isset( self::$stmts[$stmt_s])){
            return self::$stmts[$stmt_s];
        }
        $stmt_handle = self::$dbh->prepare($stmt_s);
        self::$stmts[$stmt_s]=$stmt_handle;
        return $stmt_handle;
    } 

    protected function doStatement( $stmt_s, $values_a )
    {
        $sth = $this->prepareStatement( $stmt_s );
        $sth->closeCursor();
        $db_result = $sth->execute( $values_a );
        return $sth;
    }
  
    public function lastInsertId()
    {
        //return $id;
    }

//public function execute($sql, $params = [])
   // {
   //     $sth ='';
   //    $sth = self::$dbh->prepare($sql);
   //     $res = $sth->execute($params);
   //     return $res;
   // }

    public function queryAll($sql, $arr_param =[])
    {
        $stmt = self::$dbh->prepare($sql);
        $res = $stmt->execute($arr_param);
        if (false !== $res) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return [];
    }
   
    public function queryAllClass($sql,$class)
    {
        //var_dump($sql);
        $sth = self::$dbh->prepare($sql);
        
        $res = $sth->execute();
            if (false !== $res){
            return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
        }
        return [];
        //var_dump($sth);
    }
   
   
    public function query ($sql, $q=[])
    {
        $sth = self::$dbh->prepare($sql);
        //$q =$sth->quote($q);
        $res =$sth->execute($q);
        if (false !== $res) {
           return $sth->fetch(\PDO::FETCH_ASSOC);
        }
        return [];
    }
    
    public function queryEach ($sql, $q =[])
    {
        $stmt = self::$dbh->prepare($sql);
        //$row_count = $stmt->rowCount();
        $res =$stmt->execute($q);
        if (false !== $res) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
                yield $row;
            }  
        }
        return[];
    }
   
    
   


    public function queryAllStd ($sql, $q)
    {
        $sth = self::$dbh->prepare($sql);
        $res = $sth->execute($q);
        if (false !== $res){
            return $sth->fetchAll(\PDO::FETCH_OBJ);
        }
        return [];
    }
    
    public function queryClass ($sql, $class)
    {
        $sth = self::$dbh->prepare($sql);
        $res = $sth->execute();
        if (false !== $res) {
            return $sth->fetchObject($class);
        }
        return [];
    }
    
}
