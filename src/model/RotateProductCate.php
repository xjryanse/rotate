<?php
namespace xjryanse\rotate\model;

/**
 * 各种模块通通公用的
 * 奖品类型表
 */
class RotateProductCate extends Base
{
    /**
     * 列表
     */
    public static function list( $con = [])
    {
        return self::where($con)->select();
    }
}