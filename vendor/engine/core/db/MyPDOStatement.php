<?php
namespace  engine\core\db;

use engine\core\db\DB;

class MyPDOStatement extends \PDOStatement
{
	public function execute($data = [])
	{
		parent::execute($data);
		return $this;
	}
}
