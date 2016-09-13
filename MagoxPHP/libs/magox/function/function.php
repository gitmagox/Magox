<?php

/**
 * 格式化输出函数
 * @param  all $arr  变量
 */
function p($arr){
	if( is_array($arr) || is_object($arr) ){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}else{
		echo "<pre>";
		echo $arr;
		echo "</pre>";
	}
}

/**
 * 取配置值
 * @param  $key  [description]
 * @param  $type [description]
 * @param  $model  'App/Admin' 
 */
function C($key,$type=null,$model=null){
	if( $model ){
		$modelConfig = \Magox\config::set(ROOT_PATH.$model.'/','config');
		$app = $modelConfig[$key];
		return $app;
	}
	if( null===$type ){
		$appConfig = \Magox\config::set(APP_CONFIG_PATH,'config');
		$app = $appConfig[$key];
		$sysConfig = \Magox\config::set(SYS_CONFIG_PATH,'config');
		$sys = $sysConfig[$key];
	}else{
		$appConfig = \Magox\config::set(APP_CONFIG_PATH,$type);
		$app = $appConfig[$key];
		$sysConfig = \Magox\config::set(SYS_CONFIG_PATH,$type);
		$sys = $sysConfig[$key];
	}
	
	return isset($app)&&$app ? $app : ((isset($sys)&&$sys)?$sys:null);
}

/**
 * 是否为空
 * @param  [type] $arr 变量
 * @return bool
 */
function itemIsNull($arr){

	if(is_array($arr)){
		foreach ($arr as $key => $value) {
			if(!$arr[$key]||!isset($arr[$key]))
				return 0;
		}
	}elseif(is_object($arr)){
		if(isset($arr))
			return 1;
	}else{
		if(!$arr||!isset($arr)){
			return 0;
		}
	}
	return 1;
}

//Model工厂方法
function M($table){
	return new \Magox\Model($table);
}

//自定义model工厂方法
function D($modle){
	$file = APP_MODEL_PATH.$modle.'Model.php';
	if(is_file($file)){
		eval('
			$obj = new\\'.APP_NAME.'\\Common\\Model\\'.$modle.'Model();
			return $obj;
		');
	}
}

//执行控制器
function innerRun($name,$method){
	eval('
			$obj = new \\'.APP_NAME.'\\'.NOW_APP_MODEL.'\\'.'Controller'.'\\'.NOW_APP_CONTROLLER.'Controller();
			$obj->'.$method.'();
		');
}


