<?php
namespace app\admin\controller;

use think\facade\Session;


class Brand extends Common{
    public function index(){
        if(request()->isGet()){
            //获取session值
            $session=Session::get("admin")["admin_name"];
            //var_dump($session);exit;
            return view("",["admin"=>$session]);
        }
    }


    //添加品牌
    public function add(){
        if(request()->isGet()){
            //获取session值
            $session=Session::get("admin")["admin_name"];
            //var_dump($session);exit;
            return view("",["admin"=>$session]);
        }
        if(request()->isPost()){
            //接值
            $data=request()->post();
            //var_dump($data);exit;
            $logo=request()->post("face");
            var_dump($logo);exit;
//            $arr=array_push($data,$logo);
//            var_dump($arr);exit;
            //var_dump($data);exit;
            //var_dump($logo);
            $res=\app\admin\model\Brand::add($data);


        }
    }

}