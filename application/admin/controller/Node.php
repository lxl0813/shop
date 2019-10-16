<?php
namespace app\admin\controller;


use app\admin\service\NodeService;
use think\console\command\make\Service;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;

class Node extends Common{
    public function index(){
        $session=Session::get("admin")["admin_name"];
        $data=\app\admin\model\Node::selectNode();
        $node=new NodeService();
        $data=$node->getNodeOrder($data);
        return view("",["admin"=>$session,"data"=>$data]);
    }
    public function add(){
        if(request()->isGet()){
            $session=Session::get("admin")["admin_name"];
            $data=\app\admin\model\Node::selectNode();
            $node=new NodeService();
            $data=$node->getNodeOrder($data);
            return view("",["admin"=>$session,"data"=>$data]);
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

//


}