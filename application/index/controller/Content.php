<?php
namespace app\index\controller;
use \think\Controller;
class Content extends Common
{
	public function lst()
    {
        $id = input('param.id');
        $cont = db('article')->where(['id'=>$id,'status'=>'1'])->find();
        //dump($cont);die;
        $this->assign('cont',$cont);
        $data['click'] = $cont['click']+1;
        $data['id'] = $id;
        $click = db('article')->update($data);
        $this->rec();
        $this->like();
        return view();
    }
    public function rec()
    {
        $art = db('article');
        //大图轮播（推荐最新）
        $biglist = $art->order('time desc')->limit(5)->where('thumb','<>','')->select();
        $this->assign('biglist',$biglist); 
        //首页左侧热门推荐
        $recs = $art->order('click desc,zan desc,id desc')->limit(5)->select();
        $this->assign('recs',$recs);
    }
    public function like()
    {
        $art = db('article');
        $likes = $art->order('zan desc')->limit(3)->select();
        $this->assign('likes',$likes);
    }
    public function setZan()
    {
        $data = input('param.');
        //dump($data);die;
        $res = db('article')->update($data);
        if($res){
            return json_show('1','');
        }else{
            return json_show('0','您已赞过！');
        }
    }
}
