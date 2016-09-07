<?php 
//数据库接口
namespace Magox\datebase;

interface iDB {

	public function Connect($array);

	public function Close();

	public function Query($query);

	public function Insert($table,$arr);

	public function Update($table,$arr,$where);

	public function Select($query);

	public function Del($table,$where);

	public function EscapeString($str);
}


 ?>