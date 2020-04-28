<?php 
namespace Magox;
/**
 * app返回数据格式化类
 */
class response{
	
	/**
	 * 按综合方式输出新数据
	 * @param  [type] $code    状态码
	 * @param  [type] $message 提示信息
	 * @param  array  $data    数据
	 * @return string
	 */
	public static function show($code,$message,$data=array(),$type){
	
		if($type=='json'){
			self::json($code,$message,$data);
		}elseif($type=='array'){
			var_dump($result);
		}elseif($type=='xml'){
			self::xmlEncode($code,$message,$data);
		}

	}

	/**
	 * 按json方式输出新数据
	 * @param  [type] $code    状态码
	 * @param  [type] $message 提示信息
	 * @param  array  $data    数据
	 * @return string
	 */
	public static function json($code,$message,$data=array()){
		if( !is_numeric($code)){
			return "";
		}

		$result = array(
				'code'       =>   $code,
				'message'    =>   $message,
				'data'       =>   $data
			);

		echo json_encode($result);
		exit;
	}
	/**
	 * 按xml方式输出新数据
	 * @param  [type] $code    状态码
	 * @param  [type] $message 提示信息
	 * @param  array  $data    数据
	 * @return string
	 */
	public static function xmlEncode($code,$message,$data=array()){
		if( !is_numeric($code)){
			return "";
		}

		$result = array(
				'code'       =>   $code,
				'message'    =>   $message,
				'data'       =>   $data
			);

		header("Content-type:text/xml");
		$xml = "<?xml version='1.0' encoding='utf-8 ?>\n";
		$xml. = "<root>\n";
		$xml. = self::xmlToEncode($result);
		$xml. = "</root>\n";

		echo $xml;
	}

	public static function xmlToEncode($data){

		$xml = $attr ="";
		foreach ($data as $key => $value) {
			if(is_numeric($key)){
				$attr = "id='{$key}";
				$key = "item";
			}
			$xml. = "<{$key}{$attr}>";
			$xml. = is_array($value) ? xmlToEncode($value) :$value;
			$xml. = "</{$key}>";
		}
		return $xml;
	}
}