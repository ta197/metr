<?php
namespace engine\core;

use engine\core\db\DB, 
	engine\core\base\Model;
	
class Pagination extends Model
{
	public $shift = 0;	         
	public $on_page = COUNT_ON_PAGE; // количество записей на странице
	public $url_self;       // url адрес от корня без номера с страницы (/pages/all/)
	public $page_num;       // текущая страница
	public $limit;

/////////////////////////////////////////////////////////////////////
	public function __construct($url_self)
	{
		$this->url_self = $url_self; 
		$this->page_num = 1;
	}
	
/////////////////////////////////////////////////////////////////////		
	//
	// Получить список записей из таблицы
	//
	public function limit($page_num)
	{
		$this->page_num = $page_num;
		$shift = ($this->page_num - 1) * $this->on_page;
		
		if($shift < 0)
			$shift = 0;
			
		//return "$shift, {$this->on_page}";
		$this->limit = "$shift, {$this->on_page}";
		return $this;
	} 
		
/////////////////////////////////////////////////////////////////////		
	//
	// Сформировать данные для Template (v_navbar.php)
	//
	public function navparams($count)
	{
		//$count    = $this->pagination_count();
		
		$max_page = ceil ($count / $this->on_page); 
		$left     = $this->page_num - 2;
		$right    = $this->page_num + 2;
		while($left <= 0)
		{
			$left++;
			$right++;
		}
		while($right > $max_page)
		{
			$left--;
			$right--;
		}
		//запишем в сеесию тек страницу чтоб знать куда вернуться при редиректе
		Session::push($this->url_self, $this->page_num);
		return array('on_page'  => $this->on_page,
					 'count'    => $count,
					 'left'     => $left,
					 'right'    => $right,
					 'max_page' => $max_page,
					 'page_num' => $this->page_num,
					 'url_self' => $this->url_self);
	}

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
}