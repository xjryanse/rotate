<?php
namespace xjryanse\rotate\model;

/**
 * 抽奖策略详情
 */
class RotateLimitDtl extends Base
{
    public function limitInfo()
    {
        return $this->hasOne('RotateLimitModel','id','limit_id');
    }
    
    
}