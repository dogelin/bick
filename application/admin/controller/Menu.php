<?php
namespace app\admin\controller;
use \think\Controller;
class Menu extends Common
{
	public function lst()
    {
        $menu = model('Menu')->getTree();
        $this->assign("menu",$menu);
        if(request()->isAjax()){
            $data = input("param.");
                $this->add($data);
            }
        return view();
    }
    public function add($data)
    {
        $login = model('menu');
        if($login->check($data)){
            if(!isset($data['id'])){
                //添加模块
                $add = db('cate')->insert($data);
                if($add){
                    return json_show('1','添加栏目成功');
                }else{
                    return json_show('0','添加栏目失败');
                }
            }else{
                //编辑模块
                //dump($data);die;
                $edit = db('cate')->update($data);
                if($edit !== false){
                    return json_show('1','更新栏目成功');
                }else{
                    return json_show('0','更新栏目失败');
                }
            }      
        }else{
            return json_show($login->errno,$login->errmsg);
        }
        return;
    }
    public function edit()
    {
        $menu = model('Menu')->getTree();
        $this->assign("menu",$menu);

        $id = input('param.id');
        $menus = db('cate')->where('id',$id)->find();
       // dump($menus);die;
        $this->assign('menus',$menus);
        if(request()->isAjax()){
            $data = input('param.');
           // dump($data);
             $cateid = $data['id'];
             $res = db('article')->where('cateid',$cateid)->find();
             if($data['type'] == 2 && $res){
                 return json_show('0','该栏目还有文章，类型不能为单页栏目');
             }elseif ($data['type'] == 2 && $data['url'] == '') {
                 return json_show('0','地址不能为空');
             }else{
                $this->add($data);
            }
            
        }else{
            return view();
        }
    }
    public function del()
    {
        $cate =db('cate');
        $id = input('post.id');
        $check = $cate->where('pid',$id)->find();
        //dump($check);die;
        if($check){
            return json_show('0','该栏目有子栏目，请先删除子栏目');
        }
        $art = db('article');
        $checkart = $art->where('cateid',$id)->find();
        if($checkart){
            return json_show('0','该栏目还有文章，请先删除文章');
        }
        $dels = $cate->delete($id);
        if($dels){
            return json_show('1','删除栏目成功');
        }else{
            return json_show('0','删除栏目失败');
        }
    }
}