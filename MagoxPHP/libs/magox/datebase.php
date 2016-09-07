<?php 
namespace Magox;

class datebase{

	static private $mee;
	static private $db;

	//构造方法
	private function __construct($db_type,$config){
		self::init($db_type,$config);
	}
	//单例
	static function me($db_type,$config){
		if( 1===itemIsNull(self::$mee) )
			return self::$mee;
		else
			self::$mee = new self($db_type,$config);
		return self::$mee;
	}
	//初始化
	public static function init($db_type,$config){
		$db_type = '\\Magox\\datebase\\'.$db_type;
		if( 0===itemIsNull(self::$db) )
			self::$db = new $db_type;
		self::$db->Connect($config);
	}
	//执行sql
	public static function Query($sql){
		return self::$db->Query($sql);
	}

	//执行查询
	public static function Select($sql){
		$query = self::$db->Query($sql);
		return self::$db->Select($query);
	}
	//得到行数
	public static function get_row_count(){
		return self::$db->get_row_count();
	}
	//查询全部
	public static function getAll($sql){
		$query = self::$db->Query($sql);
		return self::$db->getAll($query);
	}
	//查询一条
	public static function getOne($sql){
		$query = self::$db->Query($sql);
		return self::$db->getOne($query);
	}
	//增加数据
	public static function Insert($table,$arr){
		return self::$db->Insert($table,$arr);
	}
	//更新数据
	public static function Update($table,$arr,$where){
		return self::$db->Update($table,$arr,$where);
	}
	//册除数据
	public static function Del($table,$where){
		return self::$db->Del($table,$where);
	}
}


 ?>