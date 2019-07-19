<?php
namespace application\base;
use  application\base\_DB;
class MyPDOStatement extends \PDOStatement
{
	public function execute($data = array())
	{
		parent::execute($data);
		return $this;
	}
}
