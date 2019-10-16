<?php
namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\service\AdminService;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\View;


class Common extends Controller{
    public function __construct(){
        parent::__construct();
        //var_dump(Cookie::get("admin"));exit;
        if(Cookie::get('admin')&&!Session::get("admin")){
            $data=Cookie::get('admin');
            Session::set('admin',$data);
        }
        if(!Session::get("admin")){
            $this->success("请登录","Login/login");
        }
        if(!$this->checkNode()){
            if(request()->isAjax()){
                return ["status"=>-1,"msg"=>"没有权限操作"];
            }else{
                $this->success("你没有权限操作",'Index/index');
            }
        }
        $adminService=new AdminService();
        //调用服务层的方法获取该管理员的是否展示在左侧的权限
//        $url=$adminService->getAdminNodeId(Session::get("admin")["admin_id"]);
//        var_dump($url);exit;
        $menu=$adminService->getMenu();
        $menu=$adminService->getMenuTree($menu);

        View::share("menu",$menu);

    }

    public function checkNode(){
        //判断是否是配置文件里的超级管理员，false继续查询权限，true不需要
        if(in_array(Session::get("admin")["admin_name"],config("adminConfig.super_admin"))){
            return true;
        }
        //获取要去往的控制器和方法(转换成开头大写的格式)，判断该控制器是否是不需要权限的
        $access=ucfirst(strtolower(request()->controller()))."/".ucfirst(strtolower(request()->action()));
        if(in_array($access,config("adminConfig.no_check_action"))){
            return true;
        }
        $admin_id=Session::get("admin")["admin_id"];
        //var_dump($session);exit;
        //获取当前登录管理员的权限
        $myNode=(new AdminService())->getAdminNodeId($admin_id);
        //var_dump(Session::get("admin")["admin_id"]);
        if(in_array($access,$myNode)){
            return true;
        }else{
            return false;

        }

    }
}
