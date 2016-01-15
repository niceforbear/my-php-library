<?php

/**
 * 分治算法: O(N*logN)
 */
class A
{
    /**
     * 最大子序列和问题
     */
    public static function MaxSubSequenceSum1($arr){
        $n = count($arr);
        $maxSum = 0;
        for($i=0;$i<$n;$i++){
            for($j=$i;$j<$n;$j++){
                $thisSum = 0;
                for($k=$i;$k<=$j;$k++)
                    $thisSum += $arr[$k];

                if($thisSum > $maxSum)
                    $maxSum = $thisSum;
            }
        }
        return $maxSum;
    }

    public static function MaxSubSequenceSum2($arr){
        $maxSum = 0;
        $N = count($arr);
        for($i = 0; $i<$N; $i++){
            $thisSum = 0;
            for($j = $i; $j<$N; $j++){
                $thisSum += $arr[$j];
                if($thisSum > $maxSum)
                    $maxSum = $thisSum;
            }
        }
        return $maxSum;
    }

    /**
     * 把计算过的结果通过分治存储下来,最终进行比较
     */
    public static function MaxSubSum($arr, $left, $right){
        $maxLeftSum = $maxRightSum = 0;
        $leftBorderSum = $rightBorderSum = 0;
        $maxLeftBorderSum = $maxRightBorderSum = 0;
        $center = $i = 0;

        if($left == $right){ // Base case
            if($arr[$left] > 0)
            return $arr[$left];
        else
            return 0;
        }

        $center = intval(($left + $right) / 2);
        $maxLeftSum = A::MaxSubSum($arr, $left, $center);
        $maxRightSum = A::MaxSubSum($arr, $center+1, $right);
        for($i=$center;$i>=$left;$i--){
            $leftBorderSum += $arr[$i];
            if($leftBorderSum > $maxLeftBorderSum)
                $maxLeftBorderSum = $leftBorderSum;
        }

        for($i=$center+1;$i<=$right;$i++){
            $rightBorderSum += $arr[$i];
            if($rightBorderSum > $maxRightBorderSum)
                $maxRightBorderSum = $rightBorderSum;
        }

        return max($maxLeftSum, $maxRightSum, $maxLeftBorderSum+$maxRightBorderSum);
    }

    public static function MaxSubSequenceSum3($arr){
        $n = count($arr);
        return A::MaxSubSum($arr, 0, $n-1);
    }

    /**
     * 联机算法(online algorithm): 常量空间&线性时间
     */
    public static function MaxSubSequenceSum4($arr){
        $n = count($arr);
        $thisSum = $maxSum = $j = 0;
        for($j=0;$j<$n;$j++){
            $thisSum += $arr[$j];

            if($thisSum > $maxSum)
                $maxSum = $thisSum;
            elseif($thisSum < 0)
                $thisSum = 0;
        }
        return $maxSum;
    }

    public static function testMaxSubSequenceSum(){
        $arr = [1,2,3,-4,6,8,0,-10,-12,8];
        echo A::MaxSubSequenceSum3($arr);
    }

    /**
     * 对数特点的三个例子
     */

    public static function BinarySearch($arr, $x){
        $n = count($arr);
        $low = $mid = 0;
        $high = $n - 1;
        while($low <= $high){
            $mid = intval(($low + $high)/2);
            if($arr[$mid] < $x)
                $low = $mid + 1;
            elseif($arr[$mid > $x])
                $high = $mid - 1;
            else
                return $mid;
        }
        return false;
    }

    /**
     * 最终的非零余数$m就是最大公因数
     */
    public static function GCD($m, $n){
        $rem = 0;
        while($n > 0){
            $rem = $m % $n;
            $m = $n;
            $n = $rem;
        }
        return $m;
    }

    /**
     * 幂运算
     */
    public static function pow($x, $n){
        if($n == 0){
            return 0;
        }
        if($n == 1){
            return $x;
        }
        if($n % 2 == 1){
            return A::pow($x*$x, $n/2);
        }else{
            return A::pow($x*$x, $n/2)*$x;
        }
    }

    /**
     * 计算两个随机选取出并小于或等于N的互异正整数互素的概率: 6/(pi^2)
     * tot: 计算次数
     * rel: 命中数
     */
    public static function GCDandPOW(){
        $rel = 0; $tot = 0;
        $n = rand(10000,100000);
        for($i=1;$i<=$n;$i++){
            $tot++;
            if(A::GCD($i, $j) == 1)
                $rel++;
        }
        return $rel/$tot;
    }
}
A::testMaxSubSequenceSum();
