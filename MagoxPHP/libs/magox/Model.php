<?php 
namespace Magox;


class Model {
    static private $start
	//数据库集群实例
	static private  $dbs;
	//数据库链接实例
	static private  $db;
	//缓存链接实例
	static private  $cache;
	//sql语句---不同的date Diver来提供
	protected $sql;
	//数据表的表名
	protected $table;
	//数据表的全部字段
	protected $allFields=[];
	//隐藏的字段
	protected $hideFields=[];
	//数据表可以为空的字段
	protected $allowNullFields=[];
	//数据表的主键字段
	protected $pkField;
	//临时存入的数据
	protected $createTempData=[];
	//合法创建的数据
	protected $createData=[];
	//查询到的数据
	protected $selectData=[];
	//查询条件数组
	protected $whereArray=[];
	//查询条件
	protected $wheres;
	//order数组
	protected $orderArray=[];
	//order
	protected $orders
	//selet field
	protected $selectField = [];
	//limit数组
	protected $limitArray = [];
	//limit
	protected $limits;
	//update数组
	protected $updateArray;
	//fields
	protected $fieldArray;
	//field
	protected $fields

	public function __construct($table){
		$this->init();
		$db_name_prefix = C('DB_NAME_PREFIX','db');
		if( 0===itemIsNull($db_name_prefix) )
			exit('数据表前缀不存在，请在DB配置文件中设置:DB_NAME_PREFIX');
		$this->table =  $db_name_prefix.$table

	}
	//取注册表
	private function getStart(){
		self::$start = \Magox\start::me();
	}
	//得到数据连接的资源
	private function getDB(){
 		self::$db = $start['db'];
	}
	//get缓存连接资源
	private function getCache(){
		self::$cache = $start['cache'];
	}
	//初始化链接资源
	private function init(){
		///////////////////
		$this->getStart();
		$this->getDB();
		$this->getCache();
		///////////////////
		$this->fields = '*';
		$this->wheres = '';
		$this->orders = '';
	}

	//解析fieldArr
	private function fieldParser(&$value,$key){

		if(is_array($value)){
			list($k,$v) = each($value);
			$value = $k.' as '.$v;
		}

	}

	//解析where
	private function whereParser(&$value,$key){
		$str = '`'.$key.'` ';
		if( is_array($value) ){
			$t = $value[0];
			$v = $value[1];
			if( !is_numeric($v)&&!is_numeric($value)){
				$v = "'".$v ."'";
				$str = '`'.$key.'`';
			}
			switch (strtoupper($t)) {
				case 'EQ'  :$t = ' = '   ;break;
				case 'NEQ' :$t = ' <> '  ;break;
				case 'GT'  :$t = ' > '   ;break;
				case 'EGT' :$t = ' >= '  ;break;
				case 'LT'  :$t = ' < '   ;break;
				case 'ELT' :$t = ' <= '  ;break;
				case 'LIKE':$t = ' LIKE ';break;
				case 'IN'  :$t = ' IN '  ;break;
				default:    $t = ' = '   ;break;
			}

			$str=$str.(strtoupper($t).$v);

		}else{
			if(!is_numeric($value)){
				$value = "'".(string)$value."'";
				$str = '`'.$key.'`';
			}
			$str = $str.' = '. $value);
		}
		$value = $str;
	}

	////////////////////////public//////////////////////////////////
	// 设置field
	public function field($arr){

		if( 1===itemIsNull($arr) ){
			if(is_array($arr)){
				try {
					array_walk($arr, $this->fieldParser);
				} catch (Exception $e) {
					exit('字段不合格');	
				}
				$str = join(',',$arr);
			}else{
				$str = $arr;
			}
			$this->fields = $str;
			
		}else{
			$this->fields='*';
		}

		return $this;

	}
	//设置where;array(id=>array('eq','1'));
	public function where($arr){

		if( 1===itemIsNull($arr) ){
			if(is_array($arr)){
				array_walk($arr, $this->whereParser);
				$str = join(' AND ',$arr);
			}else{
				$str = $arr;
			}
			$this->wheres = $str;
		}
		return $this;
	}
	
	//设置表名
	public function table($val)
	{
		if($val != '')
		{
			if($this->table == '')
			{
				$this->table = $val;
			}else{
				$this->table .= ',' . $val;
			}
		}else{
			$this->table = '';
		}
		return $this;

	}
	//设置排序
	public function order($val,$by = 'desc')
	{
		if($val != '')
		{
			$str = ' order by ';
			if($this->orders == '')
			{
				$this->orders = $str . "$val $by";
			}else{
				$this->orders .= ",$val $by";
			}
		}else{
			$this->orders = '';
		}
		return $this;
	}
	//设置limit
	public function limit($str)
	{
		if( empty($str) ){
			$this->limits = '';
		}else{
			$this->limits = $str;
		}
		return $this;
	}

	public function create($arr){

	}

	public function data($arr){

	}

	public function select(){

	}

	public function  add(){

	}

	public function del(){

	}

	public function save(){

	}
	//////////////////////// protected方法 ////////////////////////
	
	protected function get_sql()
	{
		$sql = 'select ';
		$sql .= $this->fields;
		$sql .= ' from ';
		$sql .= $this->table;
		$sql .= $this->wheres;
		$sql .= $this->orders;
		$sql .= $this->limits;
		return $sql;
	}

}