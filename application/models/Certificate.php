<?php
namespace application\models;
use  engine\core\db\DB, engine\core\ToString;

class Certificate extends ToString
{
	
	static public  $pk = 'id';
	static public $table = 'certificates';
	
	public $name;
//	public $training;
//	public $category_code;
//	public $img;
	
	static public $sql;
	static public $coreProps = ['id', 'name', 'training', 'category_code', 'img', 'number', 'date', 'type', 'category_name', 'training_link'];
	

/////////////////////////////////////////////////////////////////////
	/**
	 *
	 */
	//public function __construct(){
	
	//}
	
	
	
	/////////////////////////////////////////////////////////////////////
}
