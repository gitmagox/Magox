<?php 
//接口
namespace Magox\cache;

interface icache {

	public function set($name,$value,$time);

	public function get($name);

	public function del($name);

	public function add($name,$value,$time);

	public function delAll();
}
