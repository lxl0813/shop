<?php
namespace app\admin\controller;
use app\admin\model\Admin;
use app\admin\model\Type;
use app\admin\service\TypeService;

class Attr extends Common{
    public function index(){
        $data=(new \app\admin\model\Type())->all();
        //var_dump($data);exit;
        return view("",["data"=>$data]);
    }
    public function add(){
        if(request()->isGet()){
            //调用服务层方法获取类型数据，供管理员选择类型
            $data=(new TypeService())->getType();
            return view("",["data"=>$data]);
        }
        if(request()->isPost()){
            //接值
            $data=request()->post();
            //var_dump($data);
            $data=(new \app\admin\model\Attr())->save($data);
            if($data){
                echo json_encode(["status"=>0,"msg"=>"添加属性成功"]);
            }else{
                echo json_encode(["status"=>1,"msg"=>"添加属性失败"]);
            }
        }
    }
    public function delete(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){

        }
    }
    public function update(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){

        }
    }
    //通过ajax查询所选择的类型下面的属性
    public function show(){
        //接值
        $type_id=request()->post();
        $data=\app\admin\model\Attr::where(["type_id"=>$type_id])->select()->toArray();
        //var_dump($data);exit;
        if($data){
            echo json_encode(["status"=>0,"msg"=>"查询成功","content"=>$data]);
        }else{
            echo json_encode(["status"=>1,"msg"=>"查询失败"]);
        }
    }
}