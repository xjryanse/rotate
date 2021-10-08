<?php //
namespace xjryanse\rotate\logic;

use app\rotate\model\RotateLimitModel;
use app\rotate\model\RotateLimitDtlModel;
use app\rotate\model\RotateAwardLogModel;

use app\common\abstracts\UserAbstract;
/**
 * 限制逻辑
 */
class LimitLogic extends UserAbstract
{
    use \app\common\traits\AbstractUserTrait;
    use \app\common\traits\DebugTrait;
    
    /**
     * 校验是否出奖限制
     * 【ok-20191128】
     */
    public function checkLimit( int $id )
    {
        //出奖限制详情
        $dtl = RotateLimitDtlModel::with('limitInfo')->where('rotate_dtl_id',$id)->select();
        $this->debug('出奖限制详情：LimitLogic-checkLimit',$dtl);
        //循环判断限制条件
        foreach($dtl as &$v){
            $limitInfo = $v['limit_info'];
            //筛选奖项id
            $log = RotateAwardLogModel::where('award_id',$id);
            //筛选限制类型
            $this->typeCon($log, $limitInfo['type'], $this->mobile );
            //筛选时间类型
            $this->timeTypeCon($log, $limitInfo['time_type']);
            //查询限制
            $isLimit = $this->isLimit($log, $limitInfo['limit_type'], $v['limit_value']);
            //有一个受限制即返回受限制了。
            if($isLimit){
                $this->debug('是否出奖限制：LimitLogic-checkLimit','是');
                return true;
            }
        }
        $this->debug('是否出奖限制：LimitLogic-checkLimit','否');
        return false;
    }
    
    /**
     * 记录表限制条件（人头）
     * @param object $log       记录实例
     * @param int $type         类型
     * @param string $mobile    手机号码
     * @return type
     */
    private static function typeCon(object &$log, int $type,string $mobile )
    {
        if($type == 1){
            $log->where('phone',$mobile);
        }
    }
    /**
     * 记录表限制条件（时间）
     * @param object $log
     * @param int $type
     */
    private static function timeTypeCon(object &$log, int $type )
    {
        //1每天、2每周、3每月、4全部
        switch ( $type ) {
            case 1: //每天
                $log->whereTime('create_time', 'today');
                break;
            case 2: //每周
                $log->whereTime('create_time', 'week');
                break;
            case 3: //每月
                $log->whereTime('create_time', 'month');
                break;
            default:
        }
    }
    
    /**
     * 记录表限制条件（时间）
     * @param object $log   记录实例
     * @param int $type     限制类型
     * @param type $value   限制值
     */
    private static function isLimit(object &$log, int $type, $value )
    {
        //1笔数、2额度
        switch ( $type ) {
            case 1: //笔数，达到上限为true，未达为false
                $num = $log->count();
                return $num >= $value;
            case 2: //额度，达到上限为true，未达为false
                $sum = $log->sum('award_value');
                return $sum >= $value;
            default:
        }
        return false;
    }

}



