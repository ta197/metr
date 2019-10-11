<?php
namespace engine\widgets\search;
use  engine\core\base\Model;

class Search extends Model
{
	const SEARCH_ROOT = ROOT.'/vendor/engine/widgets/search';
	const CHUNK_SEARCH_DEFAULT = self::SEARCH_ROOT.'/view/chunk_default.php';
	const VIEW_SECTION_DEFAULT = self::SEARCH_ROOT.'/view/view_section_default.php';
	const SEARCH_MAP = self::SEARCH_ROOT.'/maps/search.php';
	const EXCEPT_WORDS = self::SEARCH_ROOT.'/maps/exceptWords.php';

	public $search_query;
	public $results = [];
	public $res_map = [];

	protected $search_map;
	protected $exceptWords;
	
	protected $search_words = [];

	protected $notNeed = ['table' => '', 
							'join'=> '', 
							'left_join'=> '', 
							'where'=> '', 
							'group_by'=> '', 
							'order_by'=> '', 
							'obj' =>''];

													
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 	
	public function __construct($query)
	{
		$this->search_map = include_once(self::SEARCH_MAP);
		$this->exceptWords = include_once(self::EXCEPT_WORDS);
		
		$this->search_words = $this->clear($query)->check()->words();
		
		if($this->search_words === []){
			$this->setError('Нет ни одного слова');
		}
	}
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 	
	public function run()
	{
		$this->results = $this->find();
		$this->results = $this
				->groupByPK($this->results)
				->groupByCount($this->results)
				->sortReverce($this->results)
				->groupObj($this->results, $this->groupSubObj($this->results));

		$count_objs_in_section = $this->countObjs($this->results);
		$this->res_map = $this->sortMap($this->results)->resultMap($count_objs_in_section);
		return $this;
	}

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 	
	public function find()
	{
		foreach($this->search_words as $string):		
			foreach($this->search_map as $key => $map){
				if(count($map['search_in'] > 0)){
					$map = $this->map($map);
					$where = $this->create_condition($map['search_in'], $string);
					$dop_where = ($map['where'] != '') ? " AND {$map['where']}" : '';
					$class = (!empty($map['obj'])) ? $map['obj'] : 'application\\models\\'.ucfirst($key);

					$this->results[$key][$string] = (new $class())
						->table($map['table'])
						->fields($map['fields'], 'primary_key')
						->left_join($map['left_join'])
						->join($map['join'])
						->where("($where) $dop_where")
						->group_by($map['group_by'])
						->order_by($map['order_by'])
						->select()
						->fetchAllClass([$string]);
				}
			}
		//var_dump($this->results[$key][$string]::$sql); die;	
		endforeach;
		return $this->results;
	}

/////////////////////////////////////////////////////////////////////
    /**
     */ 	
	private function resultMap(array $countObjs)
	{
		$sort=[];
		foreach($this->search_map as $key => $map){
			if(!empty($map['view_section']) && in_array($key, $this->res_map)){
				$sort[$key]['view_section'] = $map['view_section'];
			}
			if(!empty($map['title']) && in_array($key, $this->res_map)){
				$sort[$key]['title'] = $map['title'];
			}
			if(array_key_exists($key, $countObjs)){
				$sort[$key]['count'] = $countObjs[$key];
			}
		}
		$res = [];
		foreach ($this->res_map as $k => $value) {
			$res[$k]['section'] = $value;
			foreach ($sort as $key => $arr) {
				foreach ($arr as $j => $p) {
					if ($key === $value) {
						$res[$k][$j] = $arr[$j];
					}
				}
			}
		}
		return $res;
	}

//////////////////////////////////////////////////////////////////////////////////////////
    /**
     * сортировка секций:
	 *  больше число в первом ключе (кол-во совпадений)- выше секция
	 * 1) создание массива-карты: секция => большее количество совпадений у нее (нулевое по порядку)
	 * 2) сортировка секций в карте по их значениям по убыванию
     */ 	
	private function sortMap(array $arr)
	{
		$sort_map = [];
			foreach($arr as $section=>$v){
				$keys = array_keys($v);
				$sort_map[$section] = $keys[0];
			}
		arsort($sort_map);
		$this->res_map = array_keys($sort_map);
		return $this;
	}

//////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////
    /**
     * результат - массив: 
	 * раздел=> primary_key=> порядковый номер=> объект(или список из повторов объекта)
	 * 
     */ 	
	protected function groupByPK(array $results)
	{
		$group = [];
		foreach($results as $section => $words){
			foreach($words as $word=> $list){
				foreach($list as $num=> $obj){
					$group[$section][$obj->primary_key][] =  $obj;
				}
			}
		}
		$this->results = $group;
		return $this;	
	}

/////////////////////////////////////////////////////////////////////
    /**
	 * объекты одной секции объединяются в массив с ключом - кол-во совпадений
     * раздел=> сколько совпало=> порядковый номер=> 0=> объект(или список из уникальных объектов)
     */ 	
	protected function groupByCount(array $result)
	{
		$res = [];
		foreach($result as $k=>$v){
			foreach($v as $pk=>$objects){
				$count = count($objects).' совп';
					$res[$k][$count][$pk] = $objects;	
			}
		}
		$this->results = $res;
		return $this;	
	}

/////////////////////////////////////////////////////////////////////
    /**
     * получаем массив подобъектов с ключем - $pk главного объекта
	 * оставляем только уникальные подобъекты
     */ 	
	protected function groupSubObj(array $result)
	{
		$sub=[] ;
	//получаем массив подобъектов с ключем - $pk главного объекта
		foreach($result as $section=>$arr){
			foreach ($arr as $sovp => $value) {
				foreach ($value as $pk => $objects) {
					foreach ($objects as $ord=>$object) {
						foreach ($object as $key => $prop){
							if(is_array($prop)){
								foreach ($prop as $place) {
									if(is_object($place)){
										$sub[$pk][$key][] = $place;	
									}
								}
							}
						}
					}
				}
			}
		}
	//оставляем только уникальные подобъекты
		$uniq = [];
		foreach ($sub as $pk => $props) {
			foreach ($props as $key => $places) {
				$uniq[$pk][$key] = array_unique($places);
			}
		}
		return $uniq;
	}
	
////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 	
	protected function groupObj(array $result, $sub)
	{
		$res = [];
		foreach ($result as $section => $arr) {
			foreach ($arr as $sovp => $value) {
				foreach ($value as $pk => $objects) {
					if(isset($sub[$pk])){
						foreach($sub[$pk] as $key => $places){
							$object = $objects[0];
							$object->$key = $places;
							$res[$section][$sovp][$pk][] = $object;
						}
					}else{
						$res[$section][$sovp][$pk] = array_unique($objects);	
					}
				}
			}
		}
		return $res;
	}
	
////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * сортировка по количеству совпадений на уровне отдельной секции
	 * по убыванию
     */ 	
	protected function sortReverce(array $res)
	{
		$sort = [];
		foreach($res as $section=>$arr){
				krsort($arr);
				$sort[$section] = $arr;
		}
		 $this->results = $sort;
		return $this;
	}
	
////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
	 * $this->count количество всех объектов // не используетсЯ
	 * $this->objs_section количество объектов в одной секции
     */ 	
	protected function countObjs(array $res)
	{
		//$objs = 0;
		$objs_section = [];
		foreach($res as $section=>$arr){
			$c=0;
				foreach($arr as $n=>$list){
				//	$objs += count($list);
					$c += count($list);
					$objs_section[$section] = $c;
				}
		}
		$this->count_objs_section = $objs_section;
		return $objs_section;	
	}
	
////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 	
	public function get_template($map)
	{
		return $this->search_map[$map]['template'];
	}

////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 	
	private function create_condition($fields, $string){
		$sets = array();
		
		foreach($fields as $field)
			if(mb_strlen($string) > 3){
				$sets[] = " $field LIKE '%$string%'";
			}else{
				//$string = (int)
				if(is_string($string)){
					$sets[] = " $field LIKE '%$string' OR $field LIKE '$string%'";
				}else{
					$sets[] = " $field LIKE '$string' OR $field LIKE '$string'";
				}
			}
		
		return implode(' OR ', $sets);
	}
	
////////////////////////////////////////////////////////////////	

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
	public function clear($query)
	{
		$ex = explode("=", $query);
		$q = $ex[1];
		$q = htmlspecialchars($q);
		$q = str_replace('%22', '', $q);
		$q = urldecode($q);
		$q = str_replace('«', '', $q);
		$q = str_replace('»', '', $q);
		$this->search_query = trim(strip_tags($q));
		//$string = preg_replace('/[|%_,:;?\']+/', '', $w);
		//	$string = htmlspecialchars($string);
			
		return $this;
	}

//////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
	public function check()
	{
		if(!$this->search_query){
            $this->setError('Задан пустой поисковый запрос');
        }else if (mb_strlen($this->search_query) < 2) {
			$this->setError('Слишком короткий поисковый запрос');
        } else if (mb_strlen($this->search_query) > 64) {
			$this->setError('Слишком длинный поисковый запрос');
        }	
		return $this;
	}

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
	public function words()
	{
		if((int)$this->search_query !== 0){
			$this->search_words[] = $this->is_phone($this->search_query) ? $this->is_phone($this->search_query) : (int)$this->search_query;
		}
		$query = preg_replace("|[%_,#:;?\']+|","", $this->search_query);
		$words = explode(" ", $query);

		foreach($words as $word):
			if(mb_strlen($word)>3){
				$this->search_words[] = $word;
			}
			elseif(in_array(mb_strtoupper($word), $this->exceptWords['short']['2'])){
				$this->search_words[] = $word;
			}elseif(in_array(mb_strtoupper($word), $this->exceptWords['short']['3'])){
				$this->search_words[] = $word;
			}
			$word = (int)$word;
			if($word !== 0){
				$this->search_words[] = $word;
			}
		endforeach;

		return $this->search_words;
	}

//////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
	public function is_phone($word)
	{
		$word = preg_replace("|[-( ).+?]+|","", $word);
			if(strlen($word)=== 11){
				if(substr($word, 0, 1)=='7')
					$word = substr_replace($word, '8', 0, 1);
				return (int)$word; 
			}elseif(strlen($word)==5){
				return (int)$word; 
			}
		return false;
	}

////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * Дописываем в map те поля, которые не заданы, - со значением ''
     */ 	
	private function map($map)
	{
		return $map = array_merge($this->notNeed, $map);
	}

//////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////	
}