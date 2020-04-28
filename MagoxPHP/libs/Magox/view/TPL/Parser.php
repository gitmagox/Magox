<?php

namespace Magox\view\TPL;

class Parser
{	
	//模板内容
	private $tpl;
	//解析器数组;
	private $parserDecorades = array();
	//构造方法
	public function __construct(){
		$parser = C('parser','tplparser');
		if( 0===itemIsNull($parser) ){
			exit('模板解析接口错误');
		}
		foreach ( $parser as $key => $value) {
			$parser = '\\Magox\\view\\TPL\\Parser\\'.$value;
			$this->addDecorade(new $parser());
		}
		
	}

	//设置tpl
	public function setTpl($tplfile){
		$this->tpl = file_get_contents($tplfile);
	}

	//注入解析器
	function addDecorade(parserDecorade $obj){
		$this->parserDecorades[] = $obj; 
	}

	//运行解析器
	private function runDecorade(){
		foreach ($this->parserDecorades as $value) {
			$value->setTpl($this->tpl);
			$this->tpl = $value->parser();
		}
	}

	//运行
	public function run($parserfile){
		//解析tpl
		$this->runDecorade();

		if( !file_put_contents($parserfile,$this->tpl))
			exit('ERROR: 文件'.$parserfile.'生成失败');
	}
}