<?php 
namespace Magox\datebase;

use Magox\datebase\iDB;

class mysql implements iDB{

	private $conn;
	private $rowCounts;
	private $fieldCounts;
	private $query;

	//连接数据库
	function Connect($config){

		extract($config);
		if( !($this->conn = mysql_connect($db_host,$db_user,$db_pwd)) ){
			$this->err(mysql_error());
		}
		if( !(mysql_select_db($db_name,$this->conn)) ){
			$this->err(mysql_error());
		}
		mysql_query("set names".$db_charset);
		
	}

	//执行sql语句
	function Query($sql){

		if( !($query = mysql_query($sql)) ){
			$this->err($sql."<br />".mysql_error());
		}else{
			$this->$query = $query;
			return $query;
		}

	}

	//select
	function Select($query){  

		while( $rs=mysql_fetch_array($query,MYSQL_ASSOC) ){
			$list[] = $rs;
		}
		$this->rowCounts = mysql_num_rows($query);
		$this->fieldCounts = mysql_num_fields($query);
		return isset($list)?$list:"";

	}
	//得到记录行数
	public function get_row_count(){
		return $this->rowCounts;
	}
	//查询多条数据
	function getAll($query){
		while( $rs=mysql_fetch_array($query,MYSQL_ASSOC) ){
			$list[] = $rs;
		}
		return isset($list)?$list:"";
	}
	//查询一条数据
	function getOne($query){
		$rs = mysql_fetch_array($query,MYSQL_ASSOC);
		return $rs;
	}
	//返回指定行指定字段的值
	function findResult($row = 0,$field=0){
		$rs = mysql_result($this->query,$row,$field);
		return $rs;

	}
	//insert
	function Insert($table,$arr){
		foreach($arr as $key => $value){
			$value = self::EscapeString($value);
			$keyArr[] = "`".$key.'`';
			$valueArr[] = "'".$value."'";
		}
		$keys = implode(",", $keyArr);
		$values = implode(",", $valueArr);
		$sql = "insert into ".$table."(".$keys.") value(".$values.")";
		$this->query($sql);
		return mysql_insert_id();
	}
	//update
	function Update($table,$arr,$where){

		foreach($arr as $key =>$value){
			$value = self::EscapeString($value);
			$keyAndarr[] = "`".$key."`='".$value."'";
		}
		$keyAndvalue = implode(",",$keyAndarr);
		$sql = "update ".table." set".$keyAndvalue." where ".$where;
		$this->query($sql);
	}
	//过滤
	function EscapeString($str){
		return mysql_real_escape_string($str);
	}
	//del
	function Del($table,$where){

		$sql = "delete from ".$table." where ".$where;
		$this->query($sql);

	}
	//关闭数据库
	function Close(){

	}
	function err($errow){
		die("对不起，您的操作有误，错误原因为：".$errow);
	}
}

 ?>