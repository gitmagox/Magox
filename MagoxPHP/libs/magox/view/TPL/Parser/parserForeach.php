<?php
namespace Magox\view\TPL\Parser;
use Magox\view\TPL\parserDecorade;
class parserForeach implements parserDecorade{
	private $tpl;

	function setTpl($tpl){
		$this->tpl = $tpl;
	}

	function parser(){
		$foreachPattern = '/\{foreach\s+\$([\w]+)\(([\w]+),([\w]+)\)\}/';
		$endforeachePattern = '/\{\/foreach\}/';
		$varPattern = '/\{@([\w]+)\}/';
		if( preg_match($foreachPattern, $this->tpl) ){
			if( preg_match($endforeachePattern, $this->tpl) ){
				$this->tpl = preg_replace($foreachPattern, "<?php foreach (\$this->date['$1'] as \$$2 => \$$3) { ?>", $this->tpl);
				$this->tpl = preg_replace($endforeachePattern, "<?php } ?>",$this->tpl);
				if( preg_match($varPattern,$this->tpl) ){
					$this->tpl = preg_replace($varPattern, "<?php echo \$$1 ?>", $this->tpl);
				}

			}
		}
		return $this->tpl;
	}
}