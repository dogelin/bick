<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function json_show($errno,$errmsg,$data=[]){
	$arr = [
		"errno"=>$errno,
		"errmsg"=>$errmsg,
		"data"=>$data,
	];
	exit(json_encode($arr));
}
//栏目状态
function menu_type($data){
	if($data == 1){
		return "文章列表";
	}elseif ($data == 2) {
		return "单页栏目";
	}elseif ($data == 3) {
		return "图片列表";
	}
}
//获取栏目名称
function getCateName($id){
	$cate = db('Cate')->where('id',$id)->find();
	return $cate['catename'];
}
//获取相册状态
function getThumbType($data){
	if($data !== ''){
		return '有';
	}else{
		return "<font color='red'>无</font>";
	}
}
//时间格式化
function setTime($data){
	return date('Y-m-d H:i:s',$data);
}
function setRec($data){
	return $data==1?'已推荐':'未推荐';
}
function setStatus($data){
	return $data==1?'已发布':'不发布';
}
