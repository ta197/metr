<?php
namespace  engine\core\base;

use engine\core\base\DB;

class MyPDOStatement extends \PDOStatement
{
	public function execute($data = array())
	{
		parent::execute($data);
		return $this;
	}
}
