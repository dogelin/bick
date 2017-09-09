<?php
namespace app\index\controller;
use \think\Controller;
class Menu extends Common
{
	public function lst()
    {
        $id = input('param.id');
        $cate = db('cate')->field('type,catename,url')->where('id',$id)->find();
        $catename = $cate['catename'];
        $this->assign('catename',$catename);
        $cates = db('article')->order('id desc')->where(['cateid'=>$id,'status'=>1])->paginate(3);
        $this->assign('catelist',$cates);
        $this->link();
        $this->rec();
        if($cate['type'] == 1){
            return view('artlist');
        }elseif ($cate['type'] == 3) {
            return view('imglist');
        }else{
            return view($cate['url']);
        }
        //return view();
    }
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
        $biglist = $art->order('time desc')->limit(5)->where('status','1')->select();
        $this->assign('biglist',$biglist); 
        //首页左侧热门推荐
        $recs = $art->order('click desc,zan desc,id desc')->limit(5)->where('status','1')->select();
        $this->assign('recs',$recs);
    }
    public function search()
    {
        $this->link();
        $this->rec();
        $kw = input('param.kw');
        $res = db('article')->where('title','like','%'.$kw.'%')->paginate(5);
        //dump($res);die;
        $this->assign('res',$res);
        return view();
    }
}
