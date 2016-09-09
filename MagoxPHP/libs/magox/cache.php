<?php

namespace Magox;

class cache{
	static private $mee;
	static private $cache;

	private function __construct($config){
		self::init($config);
	}
	static function init($config){
		$type = 'magox'.ucwords($config['type']);
		$type = '\\Magox\\cache\\magox'.$type;
		if( itemIsNull(self::$cache)===0 ) 
			self::$cache = $type::get_instance($config);
	}
	static public function me($config){
		if( 1===itemIsNull(self::$mee) ){
			return self::$mee;
		}else{
			self::$mee = new self($config);
		}
		return self::$mee;
	}

	public function set($name,$value){
		return self::$cache->set($name,$value);
	}

	public function get($name){
		return self::$cache->get($name);
	}

	public function del($name){
		return self::$cache->del($name);
	}

	public function add($name,$value){
		return self::$cache->add($name,$value);
	}

	public function delAll(){
		return self::$cache->delAll();
	}

}