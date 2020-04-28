<?php

namespace Magox\view\TPL\Parser;
use Magox\view\TPL\parserDecorade;

class parserInclude implements parserDecorade{
	private $tpl;

	function setTpl($tpl){
		$this->tpl = $tpl;
	}

	function parser(){
		$includePattern='/\{include\s+file=\"([\w\.\-]+)\"\}/';
		if(preg_match($includePattern, $this->tpl,$file)){
			if(!file_exists($file[1]) || empty($file)){
				exit('ERROR:引入模板文件出错');
			}
			$this->tpl = preg_replace($includePattern,"<?php include '$1' ?>", $this->tpl);
		}
		
		return $this->tpl;
	}
}