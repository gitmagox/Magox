<?php 
namespace Magox\view;

use Magox\view\iview;
use Magox\view\TPL\Parser;

class Tpl implements iview{
	//解析器类形
	private $parser_type;
	//模板目录
	private $tpl_dir;
	//缓存目录
	private $tpl_cache_dir;
	//编译目录
	private $tpl_parser_dir;
	//解析器类
	private $parser_type_object;
	//注入变量数组
	private $date = array();
	//系统变量数组
	private $sysdate = array();
	//构造方法
	public function __construct($config)
	{	
		$this->init($config);
		if( !is_dir($this->tpl_dir) || !is_dir($this->tpl_parser_dir) || !is_dir($this->tpl_cache_dir) )
			exit('ERROR:模板目录 or 缓存目录 or 编译目录 不存在！！');
		
		$parser_type = '\\Magox\\view\\TPL\\'.$this->parser_type_object;

		$this->setParser(new $parser_type()) or exit('ERROR:实例化模板解析类('.$parser_type.')失败');
		//注入系统变量
		// $_sxe = simplexml_load_file(TPL_ROOT."/config/sysvar.xml");
		// $tagLib=$_sxe->xpath('/root/tag');
		// foreach($tagLib as $tag){
		// 	$this->sysdate["$tag->name"] = "$tag->value";
		// }
	}
	private function init($config){
		$this->tpl_dir = $config['tpl_dir'];
		$this->tpl_parser_dir = $config['tpl_parser_dir'];
		$this->tpl_cache_dir = $config['tpl_cache_dir'];
		$this->parser_type_object =C('parser_type','tplparser');
	}
	//注义变量
	public function assign($tplvar,$var)
	{
		if( isset($tplvar) && !empty($tplvar) )
			$this->date[$tplvar] = $var;
		else 
			exit('ERROR:没有指定模板变量名'.$tplvar);
	}
	//加载解析模板
	public function display($_tplfile)
	{
		$tplfile = $this->tpl_dir.$_tplfile;
		$parserfile = $this->tpl_parser_dir.md5($_tplfile).$_tplfile.".php";
		$cachefile = $this->tpl_cache_dir.md5($_tplfile).$_tplfile.'.html';
		//开启缓存
		OB_START==1?ob_start():null;
		//模板文件是否存在
		if( !file_exists( $tplfile ) )
			exit('ERROR:'.$tplfile.'文件不存在');
		if( !file_exists( $parserfile) || filemtime($parserfile)<filemtime($tplfile) ){
			$this->parser_type->setTpl($tplfile);
			$this->parser_type->run($parserfile);
			//echo "我编译了一次".date('i-s',time());
		}
		//加载模板文件；		
		include $parserfile;
		if(OB_START==1){
			//生成缓存文件
			if(!file_exists($cachefile) || filemtime($cachefile)<filemtime($tplfile) ){
				file_put_contents($cachefile,ob_get_contents());
				//echo "我缓存一次".date('i-s',time());
			}
			ob_end_clean();
			include $cachefile;
		}

		


		




	}

	//设置解析器
	private function setParser(parser $ParserType){
		$this->parser_type = $ParserType;
		return true;
	}
}