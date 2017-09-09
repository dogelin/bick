<?php
namespace app\admin\model;

use think\Model;
use PasswordHash;
class Login extends Model
{
	var $errno="";
	var $errmsg="";
	public function check($data)
	{
		if($data['name'] === ""){
			$this->errno = "0";
			$this->errmsg = "用户不能为空";
			return false;
		}
		if($data['password'] === ""){
			$this->errno = "0";
			$this->errmsg = "密码不能为空";
			return false;
		}
		$login = db('admin');
		$res = $login->where('name','=',$data['name'])->find();
		 $hasher = new PasswordHash(8,false);
		if($res){
			if(!$hasher->CheckPassword($data['password'],$res['password'])){
				$this->errno = "0";
				$this->errmsg = "密码错误";
				return false;
			}else{
				$this->errno = "1";
				$this->errmsg = "登录成功";
				return true;
			}
		}else{
			$this->errno = "0";
			$this->errmsg = "用户不存在";
			return false;
		}
	}
}