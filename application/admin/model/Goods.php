<?php
namespace app\admin\model;
use think\Model;

class Goods extends Model{
    protected $pk = "goods_id";


    public function attr(){
        return $this->belongsToMany("Attr");
    }

}