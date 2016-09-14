<?php  
namespace App\Index\Controller;
use Magox\Controller;

class IndexController extends Controller{
	public function index(){
		
		
		$this->assign('show',true);
		$this->assign('name','geyan');
		$this->assign('array',array(1,2,4,5));
		$this->display();
	}
}