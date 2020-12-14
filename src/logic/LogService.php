<?php //
namespace xjryanse\rotate\logic;

use app\rotate\model\RotateAwardLogModel;

use app\common\abstracts\UserAbstract;
/**
 * 奖励记录逻辑
 */
class LogService extends UserAbstract
{
    use \app\common\traits\AbstractUserTrait;
    
    /**
     * 【操作】中奖日志记录
     * @param array RotateCateDtlModel实例化并转为数组 $detail    中奖记录
     * @param type $value                   中奖值
     */
    public function log( array $detail, $value=1,string $desc='' )
    {
        $data['token']      = $this->token;
        $data['module']     = $this->module;
        $data['openid']     = $this->openid;
        $data['msisdn']     = $this->mobile;
        $data['product_cate_id']    = &$detail['product_cate_id'];
        $data['award_id']           = &$detail['id'];
        $data['award_value']        = &$value;
        $data['award_desc']         = $desc ? : $detail['award_name'];
        $data['award_code']         = &$detail['award_code'];
        $data['status']             = 1;
        return RotateAwardLogModel::create( $data );
    }
    /**
     * 【查询】统计笔数
     * @param array $con
     * @return type
     */
    public function count( array  $con )
    {
        $con[] = ['module','=',$this->module];
        return RotateAwardLogModel::where( $con )->count();
    }
    /**
     * 【查询】统计金额
     * @param array $con
     * @return type
     */
    public function sum( array $con )
    {
        $con[] = ['module','=',$this->module];
        return RotateAwardLogModel::where( $con )->sum('award_value');
    }
}



