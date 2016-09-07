<?php 
namespace Magox;

class view{
	static private $view;
	static private $mee;
	private function __construct($config){
		self::init($config);
	}

	static public function me($config){
		if( 1===itemIsNull(self::$mee) )
			return self::$mee;
		else
			self::$mee = new self($config);
		return self::$mee;
	}

	static private function init($config){
		$type = $config['type'];
		$view_type = '\\Magox\\view\\'.$type;
		if ( itemIsNull(self::$view)===0 ){
			self::$view =  new $view_type($config);
		}
	}

	public function display($tpl){
		return self::$view->display($tpl);
	}

	public function assign($name,$val){
		return self::$view->assign($name,$val);
	}
}