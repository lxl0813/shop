<?php
namespace app\admin\controller;


use app\admin\service\NodeService;
use think\console\command\make\Service;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;

class Node extends Common{
    public function index(){
        $data=\app\admin\model\Node::selectNode();
        $node=new NodeService();
        $data=$node->getNodeOrder($data);
        return view("",["data"=>$data]);
    }
    public function add(){
        if(request()->isGet()){
            $data=\app\admin\model\Node::selectNode();
            $node=new NodeService();
            $data=$node->getNodeOrder($data);
            return view("",["data"=>$data]);
        }
        if(request()->post()){
            //接值
            $node=request()->post();

            $node=(new \app\admin\model\Node())->save($node);
            if($node){
                $this->error("权限添加成功");
            }
        }
    }

    //权限删除
    public function delete(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){

        }
    }

    //权限的修改
    public function update(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){

        }
    }


}