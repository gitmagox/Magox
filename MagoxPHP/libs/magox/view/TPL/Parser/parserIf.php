<?php
//if语句
//<?php
namespace Magox\view\TPL\Parser;
use Magox\view\TPL\parserDecorade;
class parserIf implements parserDecorade{
	private $tpl;

	function setTpl($tpl){
		$this->tpl = $tpl;
	}

	function parser(){
		$ifPattern='/\{if\s+\$([\w+])\}/';
		$endifPattern = '/\{\/if\}/';
		$elsePattern = '/\{else\}/';
		if( preg_match($ifPattern, $this->tpl) ){
			if ( preg_match($endifPattern,$this->tpl) ){
				$this->tpl = preg_replace($ifPattern, "<?php if(\$this->date['$1']){?>", $this->tpl);
				$this->tpl = preg_replace($endifPattern,"<?php } ?>",$this->tpl);

				if( preg_match($elsePattern,$this->tpl) ){
					$this->tpl = preg_replace($elsePattern, "<?php }else{ ?>", $this->tpl);
				}
			}
			else{
				exit('ERROR:IF语句没有关闭!');
			}
		}
		return $this->tpl;
	}
}