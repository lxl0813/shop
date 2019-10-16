<?php
namespace app\home\controller;

use think\Controller;

class Register extends Controller{
    public function register(){
        if(request()->isGet()){
            return view();
        }
    }
}