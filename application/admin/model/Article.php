<?php
namespace app\admin\model;

use think\Model;

class Article extends Model
{
	var $errno="";
	var $errmsg="";
	public function check($data)
	{
		if($data['cateid'] === ""){
			$this->errno = "0";
			$this->errmsg = "请选择栏目";
			return false;
		}
		if($data['title'] === ""){
			$this->errno = "0";
			$this->errmsg = "文章标题不能为空";
			return false;
		}
		if($data['content'] === ""){
			$this->errno = "0";
			$this->errmsg = "文章内容不能为空";
			return false;
		}
		return true;
	}
}