<?php
namespace app\admin\controller;
use app\admin\service\TypeService;

class Type extends Common{
    public function index(){
        $data=(new TypeService())->getType();
        //$data=(new \app\admin\model\Type())->all();
        //var_dump($data);exit;
        return view("",["data"=>$data]);
    }
    public function add(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){
            $data=request()->post();
            if($data=(new \app\admin\model\Type())->save($data)){
                $this->error("类型添加成功");
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

    public function getGroup(){
        //接值
        $type_id=request()->post("type_id");
        //var_dump($type_id);exit;
        $data=\app\admin\model\Type::where(["type_id"=>$type_id])->find();
        $arr=explode("|",$data["type_group"]);
        //var_dump($arr);exit;
        if($arr){
            echo json_encode(["status"=>0,"msg"=>"成功","content"=>$arr]);
        }else{
            echo json_encode(["status"=>1,"msg"=>"失败"]);
        }
    }

}