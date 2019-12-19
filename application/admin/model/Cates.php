<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Cates extends Model{
    protected $pk = "cates_id";
    public static function selectCate(){
        return self::select();
    }

    public static function addcate($data){
        return self::insert($data);
    }
}