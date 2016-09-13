<?php 

namespace Magox;
use Magox\datebase;
use Magox\view;
use Magox\request;


class start implements \ArrayAccess{

	//唯一的实例
	static private $mee;
	//数据库实例
	static private $db;
	//视图实例
	static private $view;
	//请求实例
	static private $start;

	static private $request;
	//缓存配置
	static private $cache;
	//当前的模块
	static private $model;
	//当前的控制器
	static private $controller;
	//当前的方法
	static private $method;
	//数据库的配置
	private $dbConfig    = [];
	//视图的配置
	private $viewConfig  = [];
	//缓存的配置
	private $cacheConfig = [];


	private function __construct(){
		self::init();
	}

	//读系统配置文件
	private function initConfig(){
		define('SYS_CONFIG_PATH',MAGOX_LIB_PATH.'config/');
		//////////////////////数据库配置/////////////////////////
		$this->dbConfig['db_type'] = C('DB_TYPE','db');
		$this->dbConfig['db_host'] = C('DB_HOST','db');
		$this->dbConfig['db_pwd']  = C('DB_PWD','db');
		$this->dbConfig['db_user'] = C('DB_USER','db');
		$this->dbConfig['db_charset'] = C('DB_CHARSET','db');
		$this->dbConfig['db_name']  =  C('DB_NAME','db');
		$this->dbConfig['db_port'] = C('DB_PORT','db');
		// p($this->dbConfig);
		/////////////////////视图的配置/////////////////////////
		$this->viewConfig['type'] = C('type','view');
		$this->viewConfig['tpl_dir'] = C('tpl_dir','view');
		$this->viewConfig['tpl_parser_dir'] = C('tpl_parser_dir','view');
		$this->viewConfig['tpl_cache_dir'] = C('tpl_cache_dir','view');
		// p($this->viewConfig);
		////////////////////缓存的配置/////////////////////////
		$this->cacheConfig['type'] = C('CACHE_TYPE','cache');
		$this->cacheConfig['cache_host'] = C('CACHE_HOST','cache');
		$this->cacheConfig['cache_port'] = C('CACHE_PORT','cache');
		$this->cacheConfig['cache_save_time'] =C('CACHE_SAVE_TIME','cache');
		// p($this->cacheConfig);
		//url模式
		$this->appUrlModel['url_model'] = C('url_model');


	}

	//初始化请求的类型
	private function initRequest(){
		self::$request = request::me();
		return ;
	}

	//初始化当前的模块
	private function initModel(){
		self::$model = self::$request->model;
		defined('NOW_APP_MODEL') OR define('NOW_APP_MODEL',self::$model);
		defined('APP_MODEL_PATH') or define('APP_MODEL_PATH',APP_PATH.'Common/');
		return ;
	}
	//初始化控制器
	private function initController(){
		self::$controller = self::$request->controller;
		defined('NOW_APP_CONTROLLER') or define('NOW_APP_CONTROLLER',self::$controller);
		defined('NOW_CONTROLLER_PATH') or define('NOW_CONTROLLER_PATH',
			APP_PATH.'/'.self::$model.'/'.'Controller/');
		return ;
	}
	//初始化方法名
	private function initMethod(){
		self::$method = self::$request->method;
		defined('NOW_APP_METHOD') or define('NOW_APP_METHOD',self::$method);
		return ;
	}
	//初始化数据连接
	private function initDatebase(){
		if( 1===itemIsNull($this->dbConfig) )
			self::$db = datebase::me($this->dbConfig['db_type'],$this->dbConfig);
	}
	//初始化缓存
	private function initCache(){
		$cacheOpen = C('cache_open','config');
		if( $cacheOpen===1 ){
			if( 1===itemIsNull($this->cacheConfig) )
			self::$cache = cache::me($this->cacheConfig);
		}	
	}

	//初始化视图
	private function initView(){
		if( 1===itemIsNull($this->viewConfig) )
			self::$view = view::me($this->viewConfig);
		return self::$view;
	}
	//初始化
	static private function init(){
		
	}
    //框架启动
	public function run(){
		if( 0===itemIsNull(self::$mee) ){
			self::$mee = new self();
		}
		self::$mee->initRequest();
		self::$mee->initModel();
		self::$mee->initController();
		self::$mee->initMethod();
		self::$mee->initConfig();
		self::$mee->initDatebase();
		self::$mee->initCache();
		self::$mee->initView();
		innerRun(self::$controller,self::$method);
	}

	//唯一的实例
	static public function me(){
		if( 0===itemIsNull(self::$mee) ){
			self::$mee = new self();
		}
		return self::$mee;
	}
	/**
	 * 根据 key 来 get 配置的值
	 * @param  key $key 配置项
	 * @return value    值
	 */
	function offsetGet( $key )
	{
		if( in_array($key, array('db','view','cache','method','model','controller')) ){
			if( 0===itemIsNull(self::$$key) ){
				$type= 'init'.ucwords($key);
				self::$$key = self::$type();
			}
			return self::$$key;

		}
		return null;
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