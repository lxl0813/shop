<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Node extends Model{
    protected $pk="node_id";
    public static function selectNode(){
        return Db::name("node")->select();
    }
    public static function addNode(){
        return self::insert();
    }
}