<?php
namespace xjryanse\rotate\traits;

/**
 * 抽奖逻辑
 */
trait RotateTrait
{
    /**
     * 传入待抽奖二维数组，进行随机出奖
     * @param type $array       奖品数组
     * @param type $chance      概率字段
     * @param type $total       总概率（防止概率下掉）
     * @return boolean
     */
    protected static function getByChance( $array,$chance='chance',$total='')
    {
        if (!$array) {
            return false;
        }
        //对象转数组
        if (is_object($array)) {
            $array = $array->toArray();
        }
        //获取概率数组，且判断概率数组之和需大于0才能出奖
        $chances = array_column($array, $chance);
        if (array_sum($chances) <= 0) {
            return false;
        }
        //防止库存不足时概率下掉
        if($total && $total > array_sum($chances)){
            //传入了总概率时，先总概率判断一下
            $randNumber = mt_rand(1,int($total));
            if($randNumber > array_sum($chances)){
                //不能中奖
                return false;
            }
        }

        //根据概率返回key值
        $key = self::getKey($chances);
        //返回中奖大类信息
        return $array[$key];
    }

    /**
     * 【ok】传入数组键值对，根据值概率返回键名，一般在随机出奖场景使用
     * @param array $arr [0=>10,1=>20];
     * @return boolean
     */
    private static function getKey(array $arr)
    {
        $total = array_sum($arr);
        if ($total <= 0) {
            return false;
        }
        foreach ($arr as $key => $value) {
            $randNumber = mt_rand(1, $total);
            //如果随机数小于当前键值返回抽奖结果
            if ($randNumber <= $value) {
                $resKey = $key;
                break;
            } else {
                $total -= $value;
            }
        }
        return $resKey;
    }
    
}
