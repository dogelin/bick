<?php
namespace app\index\controller;
use \think\Controller;
class Common extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->catelist();
	}
	public function catelist()
	{
		$cate = db('cate');
		$cates = $cate->where('pid',0)->select();
		foreach ($cates as $k => $v) 
		{
			$child = $cate->where('pid',$v['id'])->select();
			if($child){
				$cates[$k]['child'] = $child;
			}else{
				$cates[$k]['child']=0;
			}
		}
		//dump($cates);die;
		$this->assign('cates',$cates);
	}
}
