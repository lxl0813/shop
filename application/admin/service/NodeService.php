<?php

namespace app\admin\service;

class NodeService{
    //根据pid，将分类按等级处理成数组
    public function getNodeOrder($data,$pid=0,$level=0){
        $nodeOrder=[];
        foreach($data as $k=>$v){
            if($v['node_pid']==$pid){
                $v['level']=$level;
                $nodeOrder[]=$v;
                $nodeOrder=array_merge($nodeOrder,$this->getNodeOrder($data,$v['node_id'],$level+1));
            }
        }
        return $nodeOrder;
    }
}


