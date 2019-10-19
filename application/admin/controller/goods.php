<?php
namespace app\admin\controller;
use app\admin\model\Attr;
use app\admin\model\Brand;
use app\admin\service\BrandService;
use app\admin\service\CateService;
use app\admin\service\TypeService;

class Goods extends Common{
    public function index(){
        $data=(new \app\admin\model\Goods())->all()->toArray();
        return view("",["data"=>$data]);
    }
    public function add(){
        if(request()->isGet()){
            //获取商品分类
            $data=(new CateService())->cate();
            //获取商品类型
            $type=(new TypeService())->getType();
            //获取品牌信息
            $brand=(new Brand())->all()->toArray();
            return view("",["data"=>$data,"brand"=>$brand,"type"=>$type]);
        }
        if(request()->isPost()){

        }

    }

    //ajax查询类型属性
    public function getAttr(){
        $type_id=request()->post();
        $data=Attr::where(["type_id"=>$type_id])->all()->toArray();

        //var_dump($data);exit;
        if($data){
            echo json_encode(["status"=>0,"msg"=>"ok","content"=>$data]);
        }else{
            echo json_encode(["status"=>1,"msg"=>"no"]);
        }
    }




    public function delete(){
        echo "我是商品的删除";
    }
    public function update(){
        echo "我是商品的修改";
    }

}