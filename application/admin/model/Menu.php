<?php
namespace app\admin\model;

use think\Model;

class Menu extends Model
{
	var $errno="";
	var $errmsg="";
	public function getTree(){
		$menu = db('cate');
		$menus = $menu->order('pid asc ,id desc')->select();
		return self::sort($menus);
	}
	static public $treeList = array();
	static public function sort(&$data,$pid= 0 ,$level = 0){
		foreach($data as $k => $v)
		{
			if($v['pid'] == $pid){
				$v['level'] = $level;
				self::$treeList[] = $v;
				unset($k);
				self::sort($data,$v['id'],$level+1);
			}
		}
		return self::$treeList;
	}
	public function check($data)
	{
		if($data['catename'] === ""){
			$this->errno = "0";
			$this->errmsg = "名称不能为空";
			return false;
		}
		if($data['pid'] === ""){
			$this->errno = "0";
			$this->errmsg = "请选择上级栏目";
			return false;
		}
		if($data['type'] === ""){
			$this->errno = "0";
			$this->errmsg = "请选择栏目类型";
			return false;
		}
		if(!isset($data['id'])){
			$menus = db('cate');
			$res = $menus->where('catename','=',$data['catename'])->find();
			if($res){
				$this->errno = "0";
				$this->errmsg = "该栏目已存在";
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}	
	}

}