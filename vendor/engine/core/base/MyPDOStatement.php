<?php
namespace  vendor\engine\core\base;

use vendor\engine\core\DB;

class MyPDOStatement extends \PDOStatement
{
	public function execute($data = array())
	{
		parent::execute($data);
		return $this;
	}
}
