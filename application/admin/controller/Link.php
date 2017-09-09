<?php
namespace app\admin\controller;
use \think\Controller;
class Link extends Common
{
	public function lst()
    {
        $link = db('link')->order('id desc')->select();
        $this->assign("link",$link);
        if(request()->isAjax()){
            $data = input("param.");
                $this->add($data);
        }
        return view();
    }
    public function add($data)
    {
        $link = model('link');
        if($link->check($data)){
            if(!isset($data['id'])){
                //添加模块
                $add = db('link')->insert($data);
                if($add){
                    return json_show('1','添加成功');
                }else{
                    return json_show('0','添加失败');
                }
            }else{
                //编辑模块
                //dump($data);die;
                $edit = db('link')->update($data);
                if($edit !== false){
                    return json_show('1','更新成功');
                }else{
                    return json_show('0','更新失败');
                }
            }      
        }else{
            return json_show($login->errno,$login->errmsg);
        }
        return;
    }
    public function edit()
    {
        $id = input('param.id');
        $links = db('link')->where('id',$id)->find();
        $this->assign('links',$links);
        if(request()->isAjax()){
            $data = input('param.');
            //dump($data);die;
            $this->add($data);
        }else{
            return view();
        }
        
    }
    public function del()
    {
        $id = input('post.');
        $dels = db('link')->delete($id);
        if($dels){
            return json_show('1','删除成功');
        }else{
            return json_show('0','删除失败');
        }
    }
}