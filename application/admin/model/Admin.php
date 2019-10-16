<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Admin extends Model{
    protected $pk = 'admin_id';
    public static function findName($admin_name){
        return Db::name("admin")->where(["admin_name"=>$admin_name])->find();
    }
    public static function addTime($admin,$time){
        return Db::name("admin")->where("$admin")->update($time);
    }
    public static function addAdmin($data){
        return Db::name("admin")->insert($data);
    }
    public static function addAdminRole($arr){
        return Db::table("shop_admin_role")->insert($arr);
    }
    public static function select(){
        return Db::name("admin")->select();
    }
    //多对多关联（admin表和role表，通过中间表关联）
    public function role(){
        return $this->belongsToMany('Role',"admin_role","role_id","admin_id");
    }
}