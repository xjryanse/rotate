<?php
namespace xjryanse\rotate\model;
/**
 * 各种模块通通公用的
 * 抽奖记录
 */
class RotateAwardLog extends Base
{

    /**
     * 根据手机号码获取用户每日抽奖次数
     * @param type $mobile
     * @return type
     */
    public static function getDailyLuckyTimes($mobile)
    {
        return self::where('phone', $mobile)
            ->where('from', '转盘')
            ->whereTime('create_time', 'd')
            ->count();
    }
    
    
    
}