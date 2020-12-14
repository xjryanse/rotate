<?php //
namespace xjryanse\rotate\logic;

use app\rotate\model\RotateCateModel;

/**
 * 转盘奖品分类逻辑
 */
class CateLogic
{
    use \xjryanse\rotate\traits\ModuleTrait;
    use \xjryanse\rotate\traits\RotateTrait;
    use \app\common\traits\DebugTrait;
    
    /**
     * 奖池
     */
    private $cateList;

    /**
     * 获取模块原始大类奖奖池
     */
    public function getList( array $con )
    {
        $con[] = ['module','=',$this->module];
        $con[] = ['status','=',1];
        return RotateCateModel::where( $con )->select();
    }
    
    /**
     * 抽取奖品
     */
    public function rotateAward(array $con = [] )
    {
        $this->cateList = $this->getList( $con );
        $this->debug('待抽大类明细：CateLogic-rotateAward',$this->cateList);
        return $this->getByChance( $this->cateList );
    }
    
    
}



