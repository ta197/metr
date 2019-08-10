<?php
namespace  vendor\engine\core\base;

class DBException extends \PDOException
{
    private $error;
    function __construct( DB_Error $error )
    {
        parent::__construct( $error->getMessage(), $error->getCode() ); 
        $this->error = $db_error;
    }

    function getErrorObject()
    {
        return $this->error;
    }

}
