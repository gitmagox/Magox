<?php 
namespace Magox;

class request{
	//唯一的实例
	static private $mee;
	//$_server数组
	public  $server;
	//得到当的模块;
	public $model;
	//得到当前的控制器;
	public $controller;
	//得到当前的方法;
	public $method;
	//$_get数组参数
	public $get;

	public $post;

	public $url;

	//构造函数
	private function __construct(){
		$this->getServer();
		$this->getUrl();
		$this->getModel();
		$this->getPost();
	}

	//post
	private function getPost(){
		if($_POST){
			$this->post = $_POST;
			define('IS_POST',true);
			return;
		}
		define('IS_POST',false);	
	}
	//得到当前的模块
	private function getModel(){
		$url_model = C("url_model");
		$model_default = C("model_default");
		//如果设置了路由

		//如果设置了畎认的model
		if( 1===itemIsNull($model_default) ){
			$this->model = $model_default;
		}else{
			$this->model = 'Index';
		}
		//如果是普通模式
		if( 0===$url_model ){
			if($_GET){
				if($_GET['m'])
					$this->model  = $_GET['m'];
				$this->controller  = $_GET['c']?$_GET['c']:'Index';
				$this->method = $_GET['a']?$_GET['a']:'index';
				$this->get = $_GET;
				unset($this->get['m']);
				unset($this->get['c']);
				unset($this->get['a']);
				return;
			}else{
				if(1===itemIsNull($this->model)){
					$this->controller = 'Index';
					$this->method = 'index';
					return;
				}
				exit('url普能模式地址不合法');
			}
		}
		//如果严格是pathinfo模式
		if( 1===$url_model ){
			if( 1===itemIsNull($this->server['PATH_INFO']) &&
				'/'!=$this->server['PATH_INFO']){
				$path_info = $this->server['PATH_INFO'];
				$url_suffix = C('url_suffix');
				if( $url_suffix ){
					$path_info = rtrim($path_info,$url_suffix );
				}
				$path_info = trim($path_info,'/');
				$info_array = explode('/', $path_info,4);
				//取出模块控制器和方法
				$this->model = array_shift($info_array);
				$this->controller=array_shift($info_array);
				$this->method = array_shift($info_array);
				//取GET数组到get参数中
				$info_array = explode('/',$info_array[0]);
				$middel = C('middel_name_value');
				if( 0===itemIsNull($middel) ){
					for ($i=0; $i < count($info_array) ; $i=$i+2) { 
						$this->get[$info_array[$i]] = $info_array[$i+1];
					}
				}else{
					foreach ($info_array as $key => $value) {
						list($name,$val)=explode($middel,$value);
						$this->get[$name] = $val;
					}
				}
				// p($this->model);p($this->controller);p($this->method);p($this->get);
				return;
			}else{
				if(1===itemIsNull($this->model)){
					$this->controller = 'Index';
					$this->method = 'index';
					// p($this->model);p($this->controller);p($this->method);p($this->get);
					return;
				}
				exit('pathinfo地址不合法');
			}
			//这里可以做跳转
		}
		if( 2===$url_model ){
			//------------>其他模式定义
		}
	}
	//得到完整的地址
	private function getUrl(){
		$host = $this->server['HTTP_HOST'];
		$request_url = $this->server['REQUEST_URI'];
		$this->url = $host.$request_url;
	}
	//得到server数组
	private function getServer(){
		$this->server = $_SERVER;
	}
	//工厂方法
	static function me(){
		return new self;
	}

}