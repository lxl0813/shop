<?php
namespace app\admin\service;

use app\admin\model\Type;

class ProductsService{
    function getArrSet($arrs, $_current_index = -1)
    {
        //总数组
        static $_total_arr;
        //总数组下标计数
        static $_total_arr_index;
        //输入的数组长度
        static $_total_count;
        //临时拼凑数组
        static $_temp_arr;

        //进入输入数组的第一层，清空静态数组，并初始化输入数组长度
        if ($_current_index < 0) {
            $_total_arr = array();
            $_total_arr_index = 0;
            $_temp_arr = array();
            $_total_count = count($arrs) - 1;
            $this->getArrSet($arrs, 0);
        } else {
            //循环第$_current_index层数组
            if(is_array($arrs)){
                foreach ($arrs[$_current_index] as $rkey=>$v) {
                    //如果当前的循环的数组少于输入数组长度
                    if ($_current_index < $_total_count) {
                        //将当前数组循环出的值放入临时数组
                        $_temp_arr[$_current_index] = $v;
                        //继续循环下一个数组
                        $this->getArrSet($arrs, $_current_index + 1);

                    } //如果当前的循环的数组等于输入数组长度(这个数组就是最后的数组)
                    else if ($_current_index == $_total_count) //将当前数组循环出的值放入临时数组
                    {
                        $_temp_arr[$_current_index] = $v;
                        //将临时数组加入总数组
                        $_total_arr[$_total_arr_index] = $_temp_arr;
                        //总数组下标计数+1
                        $_total_arr_index++;
                    }
                }
            }

        }
        return $_total_arr;//返回值为一个数组，数组的值 冒号之前为组合内容，冒号之后为组合内容在原数组中的坐标
    }

}