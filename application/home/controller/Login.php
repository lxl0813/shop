<?php
namespace app\home\controller;

use think\Controller;

class Login extends Controller{
    public function login(){
        if(request()->isGet()){
            return view();
        }
    }
}