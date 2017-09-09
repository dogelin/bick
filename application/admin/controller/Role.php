<?php
namespace app\admin\controller;
use \think\Controller;
class Role extends Common
{
	public function lst()
    {
        $role = db('auth_group')->order('id desc')->select();
        $this->assign("role",$role);
        if(request()->isAjax()){
            $data = input("param.");
                $this->add($data);
        }
        return view();
    }
    public function add($data)
    {
        $login = model('admin');
        if($login->check($data)){
            if(!isset($data['id'])){
                //添加模块
                 $hasher = new PasswordHash(8,false);
                $data['create_time'] = date('Y-m-d H:i:s',time());
                $data['visit_time'] = date('Y-m-d H:i:s',time());
                $data['password'] = $hasher->HashPassword($data['password']);
                //dump($data);die;
                $add = db('admin')->insert($data);
                if($add){
                    return json_show('1','添加成功');
                }else{
                    return json_show('0','添加失败');
                }
            }else{
                //编辑模块
                //dump($data);die;
                 $hasher = new PasswordHash(8,false);
                $data['password'] = $hasher->HashPassword($data['password']);
                $edit = db('admin')->update($data);
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
        $menus = db('admin')->where('id',$id)->find();
        $this->assign('menus',$menus);
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
        $dels = db('admin')->delete($id);
        if($dels){
            return json_show('1','删除成功');
        }else{
            return json_show('0','删除失败');
        }
    }
}