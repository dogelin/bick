<?php
namespace app\admin\model;

use think\Model;

class Link extends Model
{
	var $errno="";
	var $errmsg="";
	public function check($data)
	{
		if($data['title'] === ""){
			$this->errno = "0";
			$this->errmsg = "名称不能为空";
			return false;
		}
		if($data['url'] === ""){
			$this->errno = "0";
			$this->errmsg = "地址不能为空";
			return false;
		}
		return true;
	}
}