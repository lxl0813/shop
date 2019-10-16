<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Role extends Model{
    protected $pk = 'role_id';
    public static function selectRole(){
        return Db::name("role")->select();
    }
    public static function addRole($data){
        return self::insert($data);
    }
    public static function findRole($data){
        return Db::name("role")->field("role_id")->where($data)->find();
    }
    public static function addNodeRole($data,$node_id){
        $arr=[];
        foreach($node_id as $k=>$v){
            $arr[]=["role_id"=>$data,"node_id"=>$v];
        }
        return Db::table("shop_role_node")->insertAll($arr);
    }
    public function node(){
        return $this->belongsToMany("Node",'role_node',"node_id","role_id");
    }
}