<?php
namespace app\admin\controller;

use app\admin\service\CateService;
use think\facade\Session;


class Brand extends Common{
    public function index(){
        if(request()->isGet()){
            $data=(new \app\admin\model\Brand())->all();
            //var_dump($data);exit;
            return view("brand/index",["data"=>$data]);
        }
    }

    //添加品牌
    public function add(){
        if(request()->isGet()){
            $arr=new CateService();
            $data=$arr->cate();
            return view("",["data"=>$data]);
        }
        if(request()->isPost()){
            //接值
            $data=request()->post();
            //var_dump($data);
            if((new  \app\admin\model\Brand())->save($data)){
                echo json_encode(["status"=>0,"msg"=>"品牌添加成功"]) ;
            }else{
                echo json_encode(["status"=>1,"msg"=>"品牌添加失败"]);
            }
        }
    }

    //删除
    public function delete(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){

        }
    }

    //修改
    public function update(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){

        }
    }
}