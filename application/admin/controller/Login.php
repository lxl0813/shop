<?php
namespace app\admin\controller;

use app\admin\model\Admin;
use think\captcha\Captcha;
use think\Controller;
use think\Db;
use think\facade\Cookie;
use think\facade\Session;
use think\Validate;

class Login extends Controller{
    public function login()
    {
        if (request()->isGet()) {
            return view("");
        }
        if (request()->isPost()) {
            //接值判断
            $admin_name = request()->post("admin_name");
            //var_dump($admin_name);exit;
            $admin_pwd = request()->post("admin_pwd");
            //var_dump($admin_pwd);exit;
            $admin_code=request()->post("admin_code");
            $save = request()->post("save");
            //var_dump($save);exit;
            if ($admin_name == "" || $admin_pwd == ""||$admin_code=="") {
                echo json_encode(["status" => 3, "msg" => "账号密码验证码不能为空"]);
            }
            $captcha = new Captcha();
            if(!$captcha->check($admin_code)){
                echo json_encode(["status" => 5, "msg" => "验证码错误"]);
            }
            $data = Admin::findName($admin_name);
            if (!$data) {
                echo json_encode(["status" => 0, "msg" => "账号不存在"]);
            } else {
                if ($data["admin_status"] != 0) {
                    echo json_encode(["status" => 1, "msg" => "该账号异常"]);
                } else {
                    //密码加密进行查询
                    $sult = $data["admin_sult"];
                    //var_dump($sult);exit;
                    if (md5(md5($admin_pwd) . $sult) != $data["admin_pwd"]) {
                        echo json_encode(["status" => 2, "msg" => "密码错误，请重新输入"]);
                    } else {
                        $arr = [
                            "admin_id" => $data["admin_id"],
                            "admin_name" => $data["admin_name"]
                        ];
                        if ($save == true) {
                            Cookie::set("admin", $arr, 7 * 24 * 3600);
                        }
                        Session::set("admin", $arr);
                        $times=Db::name("admin")->where(["admin_name"=>$admin_name])->update(["admin_last_logtime"=>time()]);
                        //$times=Admin::addTime($admin,$time);
                        if($times){
                            echo json_encode(["status" => 4, "msg" => "登录成功"]);
                        }
                    }
                }
            }
        }
    }
        //退出
    public function logout(){
        if(Cookie::get("admin")){
            Cookie::delete("admin");
        }
        Session::delete("admin");
        $this->success('退出成功','Login/login');
    }






}