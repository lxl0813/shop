<?php

namespace app\admin\service;

use app\admin\model\Cate;
use think\console\command\make\Model;
use think\Controller;

class CateService {
    public function cate(){
        $data=Cate::selectCate();
        $arr=$this->getCateOrder($data);
        return $arr;
    }

    //根据pid，将分类按等级处理成数组
    public function getCateOrder($data,$pid=0,$level=0){
        $cateOrder=[];
        foreach($data as $k=>$v){
            if($v['cate_pid']==$pid){
                $v['level']=$level;
                $cateOrder[]=$v;
                $cateOrder=array_merge($cateOrder,$this->getCateOrder($data,$v['cate_id'],$level+1));
            }
        }
        return $cateOrder;
    }
}
