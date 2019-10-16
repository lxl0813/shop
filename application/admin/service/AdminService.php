<?php

namespace app\admin\service;

use app\admin\model\Admin;
use app\admin\model\AdminRole;
use app\admin\model\Node;
use app\admin\model\Role;
use think\facade\Session;

class AdminService{
    public function getAdminNodeId($admin_id){
        $adminRoleModel=new AdminRole();
        //dump($adminRoleModel);exit;
        $role_id=$adminRoleModel->where("admin_id",$admin_id)->column("role_id");
        $roleModel=new Role();
        $role=$roleModel->all($role_id);
        $myNode=[];
        foreach($role as $key=>$val){
            $myNode=array_merge($myNode,$val->node->toArray());
        }
        $myAccess=[];
        foreach($myNode as $key=>$val){
            array_push($myAccess,ucfirst(strtolower($val["node_controller"]))."/".strtolower($val["node_action"]));
        }
        $myAccess=array_unique($myAccess);
        return $myAccess;
    }

    //取左侧菜单
    public function getMenu(){
        $admin_name=Session::get("admin")["admin_name"];
        if(in_array($admin_name,config("adminConfig.super_admin"))){
            //取所有的权限
            $menu=(new Node())->where("node_ismenu",0)->all()->toArray();
        }else{
            $admin_id=Session::get("admin")["admin_id"];
            $adminModel=new Admin();
            $admin=$adminModel->get($admin_id);
            $menu=[];
            foreach($admin->role as $key=>$val){
                $menu=array_merge($menu,$val->node->where("node_ismenu",0)->toArray());
            }
            //去重未实现
        }
        return $menu;
    }
    public function getMenuTree($menu,$pid=0){
        $menuTree=[];
        foreach($menu as $key=>$val){
            if($val["node_pid"]==$pid){
                if($son=$this->getMenuTree($menu,$val['node_id'])){
                    $val["son"]=$son;
                }
                $menuTree[]=$val;
            }
        }
        return $menuTree;
    }

}


