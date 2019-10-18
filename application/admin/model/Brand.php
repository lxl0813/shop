<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Brand extends Model{
    protected $pk = 'brand_id';
    public static function findName($admin_name){
        return Db::name("admin")->where(["admin_name"=>$admin_name])->find();
    }
    public static function add($data){
        return self::insert($data);
    }
}