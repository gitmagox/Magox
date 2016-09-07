<?php
/**
 * 自定义函数文件
 */


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