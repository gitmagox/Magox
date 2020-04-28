<?php

namespace Magox;

/**
 * config class 
 */
class Config implements \ArrayAccess
{
	static private $mee;
	protected $path;
	protected $file;
	protected $perfectName;
	protected $configs = array();

	/**
	 * 构造函数
	 */
	private function __construct($_path,$_file){
		$this->path = $_path;
		$this->file = $_file;
		$this->perfectName = $_path.$_file.'.php';
	}
	/**
	 * 设置配置目录和文件
	 * @param path $_path 配置文件目录
	 * @param file $_file 文件名
	 */
	function set($_path,$_file){
		if( !is_dir($_path) || !is_file($_path.$_file.'.php')){
			return false;
		}
		return new self($_path,$_file);	
	}
	/**
	 * 根据 key 来 get 配置的值
	 * @param  key $key 配置项
	 * @return value    值
	 */
	function offsetGet( $key )
	{
		if( empty($this->configs[$key]) ){
			$file_path =$this->perfectName;
			$this->configs = require($file_path);
		}
		return $this->configs[$key];
	}
	
	function offsetSet( $key,$value )
	{
		throw new \Exception( "cannot write config file." );
	}

	function offsetExists( $key )
	{
		return isset( $this->configs[$key] );
	}

	function offsetUnset( $key )
	{
		unset( $this->configs[$key] );
	}

}


 ?>