<?php
namespace app\admin\controller;

use app\admin\model\Node;
use think\Controller;
use think\facade\Session;
use think\validate\ValidateRule;

class Role extends Common{
    public function index(){
        $session=Session::get("admin")["admin_name"];
        $data=\app\admin\model\Role::selectRole();
        //var_dump($data);exit;
        return view("",["admin"=>$session,"data"=>$data]);
    }

    //添加角色
    public function add(){
        if(request()->isGet()){
            $session=Session::get("admin")["admin_name"];
            //查询权限
            $data=Node::selectNode();
            $data=$this->getNodeOrder($data);
            return view("",["admin"=>$session,"data"=>$data]);
        }
        if(request()->isPost()){
            //接值
            $role_name=request()->post("role_name");
            $node_id=request()->post("node_id");
            if($role_name==""){
                $this->error("角色名称不能为空");
            }
            if($node_id==""){
                $this->error("请选择权限");
            }
            //var_dump($node_id);exit;
            $acc=\app\admin\model\Role::addRole(["role_name"=>$role_name]);
            if($acc){
                $num=\app\admin\model\Role::findRole(["role_name"=>$role_name]);
                //var_dump($num);exit;
                if($node_id){
                    $data=\app\admin\model\Role::addNodeRole($num["role_id"],$node_id);
                    if($data){
                        $this->error("角色添加成功");
                    }
                }
            }
        }
    }

    //根据pid，将权限按等级处理成数组
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
