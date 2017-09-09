<?php
namespace app\admin\model;

use think\Model;

class Admin extends Model
{
	var $errno="";
	var $errmsg="";
	public function check($data)
	{
		if($data['password'] === ""){
			$this->errno = "0";
			$this->errmsg = "密码不能为空";
			return false;
		}
		if($data['name'] === ""){
			$this->errno = "0";
			$this->errmsg = "用户不能为空";
			return false;
		}
		if(!isset($data['id'])){
			$login = db('admin');
			$res = $login->where('name','=',$data['name'])->find();
			if($res){
				$this->errno = "0";
				$this->errmsg = "该用户已存在";
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
		
	}
}