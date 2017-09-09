<?php
namespace app\admin\controller;
use \think\Controller;
class Article extends Common
{
	public function lst()
    {
        $menus = model('Menu')->getTree();
        $this->assign('menu',$menus);
        $art = db('article')->order('time desc')->paginate(10);
        $this->assign("art",$art);
        if(request()->isAjax()){
            $data = input("param.");
            //dump($data);die;
             $this->add($data);
        }
        return view();
    }
    public function add($data)
    {
        $login = model('article');
        if($login->check($data)){
            $data['time'] = time();
            if(!isset($data['id'])){
                //添加模块
                $add = db('article')->insert($data);
                if($add){
                    return json_show('1','添加文章成功');
                }else{
                    return json_show('0','添加文章失败');
                }
            }else{
                //编辑模块
                //dump($data);die;
                $edit = db('article')->update($data);
                if($edit !== false){
                    return json_show('1','更新文章成功');
                }else{
                    return json_show('0','更新文章失败');
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
        $arts = db('article')->where('id',$id)->find();
       // dump($menus);die;
        $this->assign('art',$arts);
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
        $art =db('article');
        $id = input('post.id');
        $dels = $art->delete($id);
        if($dels){
            return json_show('1','删除文章成功');
        }else{
            return json_show('0','删除文章失败');
        }
    }
    public function status()
    {
        $data = input('param.');
        //dump($data);die;
        $name = $data['name'];
        $res = db('article')->field($name)->where('id',$data['id'])->find();
       // dump($res);die;
        $res['id'] = $data['id'];
        $res[$name] = $res[$name]==1?0:1;
        //
        $change = db('article')->update($res);
        $data[]=$res[$name];
        $data[]=$name;
        if($change){
            return json_show('1','更新状态成功',$data);
        }else{
            return json_show('0','更新状态失败');
        }
    }
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('photo');
        //dump($file);die;
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=>3145728,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $savename = str_replace('\\', '/', $info->getSaveName());
            return json_show('1','',$savename);
        }else{
            // 上传失败获取错误信息
            return json_show('0',$file->getError());
        }
    }
}