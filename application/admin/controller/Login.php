<?php
namespace app\admin\controller;
use think\Controller;
class Login extends Controller
{
    public function login()
    {
         $login = model('login');
        if(request()->isAjax()){
         	$data = input("param.");
         	if($login->check($data)){
                $id = db('admin')->where('name','=',input("name"))->field('id')->find();
                session('name',input("name"));
                session('id',$id);
                $res = [
                 'errno'=>$login->errno,
                 'errmsg'=>$login->errmsg
                ];
                return json($res);
         	}else{
                $res = [
                 'errno'=>$login->errno,
                 'errmsg'=>$login->errmsg
                ];
                return json($res);
         	}           
         	return;
        }
        return view();
    }
    public function logout()
    {
        session(null);
        $this->redirect('login');
    }
}
