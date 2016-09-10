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
 * 
 */
function C($key,$type=null){
	if( null===$type ){
		$appConfig = \Magox\config::set(APP_CONFIG_PATH,'config.php');
		$app = $appConfig[$key];
		$sysConfig = \Magox\config::set(SYS_CONFIG_PATH,'config.php');
		$sys = $sysConfig[$key];
	}else{
		$appConfig = \Magox\config::set(APP_CONFIG_PATH,$type.'.php');
		$app = $appConfig[$key];
		$sysConfig = \Magox\config::set(SYS_CONFIG_PATH,$type.'.php');
		$sys = $sysConfig[$key];
	}
	// p($app);
	// p($sys);
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


function M($table){
	return new \Magox\Model($table);
}