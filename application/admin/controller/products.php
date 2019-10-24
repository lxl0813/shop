<?php
namespace app\admin\controller;
use app\admin\model\Attr;
use app\admin\model\GoodsAttr;
use app\admin\service\ProductsService;

class Products extends Common{
    public function index(){
        $goods_id=request()->get("goods_id");
        //var_dump($goods_id);exit;
        $data=\app\admin\model\Products::where(["goods_id"=>$goods_id])->all();
        return view('',["data"=>$data,"goods_id"=>$goods_id]);
    }

    public function add(){
        if(request()->isGet()){
            $goods_id=request()->get("goods_id");
            $q=GoodsAttr::field("attr_id")->where(["goods_id"=>$goods_id])->all()->toArray();
            $q=array_unique($q, SORT_REGULAR);
            //var_dump($q);exit;
            $w=[];
            foreach($q as $k=>$v){
                $w[]=Attr::field("attr_id")->where(["attr_id"=>$v["attr_id"],"attr_type"=>0])->all()->toArray();
            }
            foreach($w as $k=>$v){
                foreach($v as $key=>$value){
                    $e[]=GoodsAttr::where(["attr_id"=>$value["attr_id"],"goods_id"=>$goods_id])->all()->toArray();
                }
            }
            //对属性值进行组合（也就是货品）
            $attr=(new ProductsService())->getArrSet($e);
            //var_dump($e);exit;



//            $a=GoodsAttr::where(["goods_id"=>$goods_id])->all()->toArray();
//
//            //var_dump($a);exit;
//            $arr=[];
//            foreach($a as $k=>$v){
//                $arr[$v["attr_id"]][]=$v;
//            }
//            foreach($arr as $key=>$value){
//                $res[]=$value;
//            }
//            //dump($res);exit;
//            $attr=(new ProductsService())->getArrSet($res);
//            //var_dump($attr);exit;
            $b=[];
            foreach($q as $k=>$v){
                foreach(Attr::field("attr_name")->where(["attr_id"=>$v["attr_id"],"attr_type"=>0])->all()->toArray() as $key=>$value){
                    $b[]=$value;
                }
            }
            //对属性名称去重
            $b=array_unique($b, SORT_REGULAR);
            //var_dump($b);exit;
            return view("",["a"=>$attr,"b"=>$b,"goods_id"=>$goods_id]);
        }
        if(request()->isPost()){
            $data=input("post.arr");
            //dump($data);exit;
            $res=new \app\admin\model\Products();
            $res->saveAll($data);
            if($res){
                echo json_encode(["status"=>0,"msg"=>"添加成功"]);
            }else{
                echo json_encode(["status"=>1,"msg"=>"添加失败"]);
            }
        }
    }
}