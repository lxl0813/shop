<?php
namespace app\admin\controller;
use app\admin\model\Attr;
use app\admin\model\Brand;
use app\admin\model\GoodsAttr;
use app\admin\model\Products;
use app\admin\service\BrandService;
use app\admin\service\CateService;
use app\admin\service\ProductsService;
use app\admin\service\TypeService;
use think\validate\ValidateRule;

class Goods extends Common{
    public function index(){
        $data=(new \app\admin\model\Goods())->paginate(5);
        //$data=$this->assign("list",$list);
        //var_dump($data);
        $cate=(new CateService())->cate();
        //return $this->fetch();
        return view("",["data"=>$data,"cate"=>$cate]);
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
            $data=request()->post();
            //dump($data);exit;
            if($data["cate_id"==0]){
                $this->error("请选择分类");
            }

            if($data["brand_id"==0]){
                $this->error("请选择品牌");
            }
            //对分类去重
            $arr=array_unique($data["cate_id"]);
            $data["cate_id"]=implode("|",$arr);

            //如果没有填写货号，随机生成一个
            if($data["goods_item_num"]==""){
                $data["goods_item_num"]="sp-".substr(uniqid(),-8);
            }
            //dump($data);
            //将日期转换成时间戳
            $data["goods_pro_sdate"]= strtotime($data["goods_pro_sdate"]);
            $data["goods_pro_fdate"]= strtotime($data["goods_pro_fdate"]);
            //重量单位拼接
            if($data["company"]==0){
                $data["company"]="克";
            } else{
                $data["company"]="千克";
            }
            $data["goods_weight"]=$data["goods_weight"].$data["company"];
            unset($data["company"]);
            //dump($data);exit;

            //去重
            $temp=[];
            foreach ($data["attr_value"] as $k=>$v){
                $v=join(',',$v); //降为一维数组
                $temp[$k]=$v;
            }
            //var_dump($temp);exit;
            $w=[];
            foreach($temp as $k=>$v){
                $arr = explode(',', $v);
                //var_dump($arr);exit;
                $res = array_unique($arr);//内置数组去重算法
                //var_dump($res);exit;
                $w[$k] = implode(',', $res);

            }
            //var_dump($w);exit;
            $data["attr_value"] =[];
            foreach ($w as $k => $v){
                $array=explode(',',$v);
                foreach($array as $key=>$value){
                    $data["attr_value"][$k][] =$value;
                }
            }
            //var_dump($data["attr_value"]);exit;
            //处理$data["attr_value"]数组
            $d=[];
            foreach($data["attr_value"] as $k=>$v){
                //var_dump($v);exit;
                foreach($v as $key=>$value){
                    $d[]=['attr_id'=>$k,"attr_value"=>$value];
                }
            }

            //入库goods表
            //添加商品表
            $A=new \app\admin\model\Goods();
            $A->save($data);
            $goods_id=$A->goods_id;
            //var_dump($goods_id);exit;
            //dump($A);

//            //添加到商品属性表
//            foreach($d as $k=>$v){
//                //var_dump($v);exit;
//                $res=$A->attr()->attach($v["attr_id"],$v);
//            }
//            //var_dump($data);exit;
//
//            //直接添加货品表
//            $a=GoodsAttr::where(["goods_id"=>$goods_id,""])->all()->toArray();
//            //var_dump($a);exit;
//            $arr=[];
//            if(isset($a)){
//                foreach($a as $k=>$v){
//                    $arr[$v["attr_id"]][]=$v;
//                }
//            }
//            foreach($arr as $key=>$value){
//                $r[]=$value;
//            }
//            //dump($r);exit;
//            $attr=(new ProductsService())->getArrSet($r);
//            dump($attr);exit;
//            foreach($attr as $k=>$v){
//                $ree=(new Products())->saveAll($v);
//            }

            if($res){
                $this->success("商品添加成功","Goods/index");
            }else{
                $this->error("商品添加失败");
            }





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

    //点击更改商品状态
    public function goodsStatus(){
        $data=request()->post();
        if($data["goods_status"]==0){
            $data["goods_status"]=1;
        }else{
            $data["goods_status"]=0;
        }
        $data= \app\admin\model\Goods::where(["goods_id"=>$data["goods_id"]])->update(["goods_status"=>$data["goods_status"]]);
        if($data){
            echo json_encode(["status"=>0,"msg"=>"修改成功"]);
        }else{
            echo json_encode(["status"=>1,"msg"=>"修改失败"]);
        }
    }

    //点击更改商品是否热销
    public function ishot(){
        $data=request()->post();
        if($data["goods_ishot"]==0){
            $data["goods_ishot"]=1;
        }else{
            $data["goods_ishot"]=0;
        }
        $data= \app\admin\model\Goods::where(["goods_id"=>$data["goods_id"]])->update(["goods_ishot"=>$data["goods_ishot"]]);
        if($data){
            echo json_encode(["status"=>0,"msg"=>"修改成功"]);
        }else{
            echo json_encode(["status"=>1,"msg"=>"修改失败"]);
        }
    }

    //点击更改商品是否新品
    public function isnew(){
        $data=request()->post();
        if($data["goods_isnew"]==0){
            $data["goods_isnew"]=1;
        }else{
            $data["goods_isnew"]=0;
        }
        $data= \app\admin\model\Goods::where(["goods_id"=>$data["goods_id"]])->update(["goods_isnew"=>$data["goods_isnew"]]);
        if($data){
            echo json_encode(["status"=>0,"msg"=>"修改成功"]);
        }else{
            echo json_encode(["status"=>1,"msg"=>"修改失败"]);
        }
    }

    //点击更改商品是否促销
    public function ispro(){
        $data=request()->post();
        if($data["goods_ispro"]==0){
            $data["goods_ispro"]=1;
        }else{
            $data["goods_ispro"]=0;
        }
        $data= \app\admin\model\Goods::where(["goods_id"=>$data["goods_id"]])->update(["goods_ispro"=>$data["goods_ispro"]]);
        if($data){
            echo json_encode(["status"=>0,"msg"=>"修改成功"]);
        }else{
            echo json_encode(["status"=>1,"msg"=>"修改失败"]);
        }
    }

    public function image(){

    }
}