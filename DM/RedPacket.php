<?php

/**
 * Created by PhpStorm.
 * User: niceforbear
 * Date: 16/1/17
 * Time: 下午11:11
 */
class RedPacket
{
    private function sqr($n){
        return $n*$n;
    }

    /**
     * 膨胀再收缩法
     */
    public function xRandom($bonusMin, $bonusMax){
        $sqr = intval($this->sqr($bonusMax - $bonusMin)); // 获得差值的平方值
        $randNum = rand(0, ($sqr - 1)); // 从0到差值的平均值之间选择一个随机数作为xRandom
        return intval($randNum);
    }

    public function getBonus($bonusTotal, $bonusCount, $bonusMax, $bonusMin){
        $result = [];
        $average = $bonusTotal / $bonusCount;

        $a = $average - $bonusMin; //
        $b = $bonusMax - $bonusMin;

        $range1 = $this->sqr($average - $bonusMin);
        $range2 = $this->sqr($bonusMax - $average);

        for($i=0; $i<$bonusCount; $i++){
//            wtf
        }
    }
}