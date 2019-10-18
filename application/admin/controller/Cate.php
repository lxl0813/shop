<?php
namespace app\admin\controller;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;
use app\admin\service\CateService;
class Cate extends Common{
    public function index(){
       if(request()->isGet()){
             $arr=new CateService();
             $data=$arr->cate();
             //var_dump($data);exit;
           return view("Cate/index",["data"=>$data]);
       }
    }

//    //根据pid，将分类按等级处理成数组
//    public function getCateOrder($data,$pid=0,$level=0){
//        $cateOrder=[];
//        foreach($data as $k=>$v){
//            if($v['cate_pid']==$pid){
//                $v['level']=$level;
//                $cateOrder[]=$v;
//                $cateOrder=array_merge($cateOrder,$this->getCateOrder($data,$v['cate_id'],$level+1));
//            }
//        }
//        return $cateOrder;
//    }

    //添加分类
    public function add(){
        if(request()->isGet()){
            $arr=new CateService();
            $data=$arr->cate();
            return view("",["data"=>$data]);
        }
        if(request()->isPost()){
            //接值
            $cate_name=request()->post("cate_name");
            if($cate_name==""){
                $this->error("分类名称不能为空");
            }
            $cate_show=request()->post("cate_show");
            $cate_navigation=request()->post("cate_navigation");
            $cate_pid=request()->post("cate_pid");
            $cate_keyword=request()->post("cate_keyword");
            $cate_content=request()->post("cate_content");
            if($cate_content==""){
                $this->error("分类介绍不能为空");
            }
            $cate_order=request()->post("cate_order");
            $data=["cate_name"=>$cate_name,"cate_show"=>$cate_show,"cate_navigation"=>$cate_navigation,"cate_pid"=>$cate_pid
                   ,"cate_keyword"=>$cate_keyword,"cate_content"=>$cate_content,"cate_order"=>$cate_order
            ];
            $arr=\app\admin\model\Cate::addcate($data);
            if($arr){
                $this->error("添加分类成功");
            }
        }
    }

    //分类删除
    public function delete(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){

        }
    }

    //分类修改
    public function update(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){

        }
    }
}