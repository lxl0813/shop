<?php

namespace app\admin\service;

use app\admin\model\Type;

class TypeService{
    public function getType(){
        $data=(new \app\admin\model\Type())->all()->toArray();
        return $data;
    }
}


