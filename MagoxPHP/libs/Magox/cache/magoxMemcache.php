<?php
/**
 * Memcache class
 * @author 葛艳(Magox)---2016-8-18
 */

namespace Magox\cache;

use Magox\cache\icache;

class magoxMemcache implements icache{

	static private $cache;
	static private $hosts=array();
	static private $host = array('host'=>'localhost','port'=>'11211');
	static private $mem;
	static private $SaveTime = 3600;

	//构造函数
	private function __construct($config){
		if (!extension_loaded('memcache')) {
            throw new \BadFunctionCallException('not support: memcache');
        }
		$this->init($config);
	}
	//初始化连接
	private function init($config){
		$this->host['host'] = $config['cache_host'];
		$this->host['port'] = $config['cache_port'];
		$this->SaveTime = $config['cache_save_time'];
		defined('S_CACHE_SAVE_TIME') or define('S_CACHE_SAVE_TIME',$this->SaveTime);
		$this->connect();
	}
	//得到唯一的$cache;
	public function get_instance($config){
		if( 0===itemIsNull($cache) ){
			self::$cache = new self($config);
			return self::$cache;
		}else{
			return self::$cache;
		}
	}
	
	private function connect(){
		if( 0===itemIsNull(self::$mem) ){
			self::$mem = new \memcache();
			self::$mem->connect($this->host['host'],$this->host['port']);
			$this->addHost();
		}
	}
	//增加服务器
	private function addHost(){
		if(isset(self::$hosts)&&is_array(self::$hosts)){
			try {
				foreach (self::$hosts as $host) {
				self::$mem->addServer($host['host'],$host['port']);
				}
				return true;
			} catch (Exception $e) {
				return $e->getMessage();
			}
		}else{
			return false;
		}
	}
	//设置变量
	public function set($name,$value,$time=S_CACHE_SAVE_TIME){
		return self::$mem->set($name,$value,MEMCACHE_COMPRESSED,$time);
	}
	//增加变量
	public function add($name,$value,$time=S_CACHE_SAVE_TIME){
		return self::$mem->add($name,$value,MEMCACHE_COMPRESSED,$time);
	}
	//得到变量
	public function get($name){
		return self::$mem->get($name);
	}
	//册除变量
	public function del($name){
		return self::$mem->delete($name);
	}
	//册除所有的变量
	public function delAll(){
		return self::$mem->flush();
	}


}