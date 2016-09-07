<?php
/**
 * Load class
 */
namespace Magox;

class Load{
	static private $load;

	static private $start;
	//APP目录
	private $app_path;
	//APP公共目录
	private $app_include_path;
	//APP公共控制器目录
	private $app_include_cotroller_path;
	//APP公共模形目录
	private $app_include_model;
	//APP模块目录
	private $app_model;
	//App模块控制器
	private $app_model_controller_path;
	//APP模块模形
	private $app_model_model_path;
	/**
	 * 自动加载类
	 * @param  [type] $class [description]
	 * @return [type]        [description]
	 */
	static function autoload($class){
		$classDir = str_replace('\\', '/', $class);
		if( 0===strpos($classDir, 'Magox') ){
			include_once MAGOX_PATH.'libs/'.$classDir.'.php';
		}else{
			include_once ROOT_PATH.$classDir.'.php';
		}
	}
}
