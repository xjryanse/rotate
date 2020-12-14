<?php //
namespace xjryanse\rotate\logic;

use app\rotate\model\RotateCateDtlModel;

/**
 * 转盘具体奖品出奖逻辑
 */
class CateDtlLogic
{
    use \xjryanse\rotate\traits\ModuleTrait;
    use \xjryanse\rotate\traits\RotateTrait;
    
    /**
     * 奖品分类id
     */
    private $cateId;
    /**
     * 奖池
     */
    private $detailList;
    /**
     * 设置分类id
     * @param type $cateId
     */
    public function setCateId( $cateId )
    {
        $this->cateId = $cateId;
    }
    /**
     * 获取分类id
     */
    public function getCateId( )
    {
        return $this->cateId;
    }
    /**
     * 获取模块原始大类奖奖池
     */
    public function getList()
    {
        if(!$this->cateId){ return false;}
        $con[] = ['module','=',$this->module];
        $con[] = ['cate_id','=',$this->cateId];
        $con[] = ['status','=',1];
        return RotateCateDtlModel::where( $con )->select();
    }
    /**
     * 抽取奖品
     */
    public function rotateAward()
    {
        if(!$this->detailList){
            $this->detailList = $this->getList();
        }
        if(!$this->detailList){
            return false;
        }
        return $this->getByChance( $this->detailList );
    }
    /**
     * 利用指定的id出奖
     * 一般在出低值奖项上使用
     */
    public function getById( int $id )
    {
        $con[] = ['id','=',$id];
        $con[] = ['module','=',$this->module];
        $con[] = ['status','=',1];
        return RotateCateDtlModel::where( $con )->find();
    }
}



