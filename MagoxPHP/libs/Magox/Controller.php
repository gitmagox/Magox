<?php

namespace Magox;

class Controller {
	private $start;
	protected $view;

	//构造方法
	public function __construct(){
		//初始化视图
		$this->getView();
		//如果存在init方法,就执行init方法
		if( method_exists($this, 'init') ){
			$this->init();
		}
	}
	//得到
	protected function getView(){
		$this->start = \Magox\start::me();
		$this->view = $this->start['view'];
	}

	//加载模板
	protected function display($tpl=null){
		if(0===itemIsNull($this->view)){
			$this->getView();
		}
		if(null===$tpl){
			$tpl=$this->start['model'].'/'.$this->start['controller'].'/'.$this->start['method'];
		}
		$tpl = $tpl.'.php';

		return $this->view->display($tpl);
		
	}
	//注入变量
	protected function assign($name,$value){
		if(0==itemIsNull($this->view)){
			$this->getView();
		}
		return $this->view->assign($name,$value);
	}
	//成功跳转


}