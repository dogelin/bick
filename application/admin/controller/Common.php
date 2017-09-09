<?php
namespace app\admin\controller;
use think\Controller;
class Common extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!session("?name")){
            $this->error("请先登录",url("login/login"));
        }
    }
}
