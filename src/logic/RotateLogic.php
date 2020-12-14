<?php
namespace xjryanse\rotate\logic;


/**
 * 抽奖逻辑
 */
class RotateLogic
{
    use \xjryanse\traits\DebugTrait;
    use \xjryanse\traits\InstTrait;
    /**
     * 入参：模块名、用户手机号码
     * 返回：一条奖品信息
     */
    public function rotate(int $defaultNum = 17)
    {
        $this->module = 'yd002';
        //①抽大类
        $cate       = CateLogic::getInstance( $this->module )->rotateAward();
        $this->debug('随机出奖的大类：RotateService-rotate',$cate);
        
        //②抽小类
        $detailInst = CateDtlLogic::getInstance( $this->module );
        $detailInst ->setCateId($cate['id']);
        $detail     = $detailInst->rotateAward();
        $this->debug('随机抽中的小类奖：RotateService-rotate',$detail);
        
        //③校验出奖条件是否符合，不符合时送谢谢惠顾
        if(LimitLogic::getInstance($this->fansInfo)->checkLimit( $detail['id'])){
            //出谢谢惠顾
            $detail     = $this->default( $defaultNum );        
        }
        $this->debug('实际出的小类奖详情：RotateService-rotate',$detail);
        
        if(!$detail){
            return false;
        }
        $log = LogService::getInstance( $this->fansInfo )->log( $detail );
        //发送到通知地址
        if( $log ){
            
        }
        
        //③记录
        return LogService::getInstance( $this->fansInfo )->log( $detail );
    }
    /**
     * 不符合出奖条件时，专出低值奖项。
     */
    public function default($id = 0)
    {
        if(!$id){
            return false;
        }
        $res = CateDtlLogic::getInstance( $this->module )->getById( $id );
        return is_object( $res ) ? $res->toArray() : $res;
    }

}
