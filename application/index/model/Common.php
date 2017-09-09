<?php
namespace app\index\model;

use think\Model;

class Common extends Model
{
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
}