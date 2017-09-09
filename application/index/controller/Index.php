<?php
namespace app\index\controller;
use \think\Controller;
class Index extends Common
{
	public function Index()
    {
    	$this->link();
    	$this->rec();
    	$this->show();
        return view();
    }
    //首页文章显示
    public function show()
    {
    	$arts = db('article')->order('time desc')->where('status',1)->paginate(4);
    	$this->assign('arts',$arts);
    }
    //友情链接
    public function link()
    {
    	$link = db('link');
    	$links = $link->select();
    	$this->assign('links',$links);
    }
    //
    //推荐
    public function rec()
    {
    	$art = db('article');
    	//大图轮播（推荐最新）
    	$biglist = $art->order('time desc')->limit(5)->where('status',1)->select();
    	$this->assign('biglist',$biglist); 
    	//首页左侧热门推荐
    	$recs = $art->order('click desc,zan desc,id desc')->where('status',1)->limit(5)->select();
    	$this->assign('recs',$recs);
    }
}
