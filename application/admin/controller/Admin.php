<?php
namespace app\admin\controller;

use app\admin\model\Role;
use app\admin\service\AdminService;
use think\Controller;
use think\facade\Session;
use think\validate\ValidateRule;

class Admin extends Common{
    public function index(){
        $session=Session::get("admin")["admin_name"];
        $data=(new \app\admin\model\Admin())->all();
        return view("admin/index",["admin"=>$session,"data"=>$data]);
    }

    //添加管理员
    public function add(){
        if(request()->isGet()){
            $session=Session::get("admin")["admin_name"];
            $data=Role::selectRole();
            return view("",["admin"=>$session,"data"=>$data]);
        }
        if(request()->isPost()){
            //接值
            $admin_name=request()->post("admin_name");
            $admin_pwd=request()->post("admin_pwd");
            $role_name=request()->post("role_name");
            //var_dump($role_name);exit;
            if("$admin_name"==''){
                $this->error("管理员名称不能为空");
            }
            if($admin_pwd==""){
                $this->error("密码不能为空");
            }
            $sult=substr(rand(),-4);
            $pwd=md5(md5($admin_pwd).$sult);
            $data=\app\admin\model\Admin::addAdmin(["admin_name"=>$admin_name,"admin_pwd"=>$pwd,"admin_sult"=>$sult,"admin_add_time"=>time()]);
            //var_dump($data);exit;
            $arr=\app\admin\model\Admin::findName(["admin_name"=>$admin_name]);
            $res=\app\admin\model\Admin::addAdminRole(["admin_id"=>$arr["admin_id"],"role_id"=>$role_name]);
            if($data&&$arr&&$res){
                $this->error("管理员添加成功");
            }
        }
    }
}
