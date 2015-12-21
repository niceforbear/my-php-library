<?php

/**
 * Created by PhpStorm.
 * User: niceforbear
 * Date: 15/12/22
 * Time: 上午1:06
 */
class ITSP
{
    public static function insertSort(){

    }

    public static function selectSort(){

    }

    public static function binaerSearchIterative($arr, $val, $left, $right){
        while($left <= $right){
            $mid = (int)(($right - $left)/2 + $left);
            if($val == $arr[$mid]){
                return $mid;
            }elseif($arr[$mid] > $val){
                $right = $mid-1;
            }else{
                $left = $mid+1;
            }
        }
        return -1;
    }

    public static function binarySearch($arr, $val, $left, $right){
//        $orderArr = ITSP::bubbleSort($arr);
        if($left > $right){
            return false;
        }
        $mid = (int)(($right-$left)/2 + $left);
        if(isset($arr[$mid]) && $arr[$mid] == $val){
            return $mid;
        }elseif($arr[$mid] > $val){
            return ITSP::binarySearch($arr, $val, $left, $mid-1);
        }else {
            return ITSP::binarySearch($arr, $val, $mid+1, $right);
        }
    }

    public static function bubbleSort($arr){
        $count = count($arr);
        for($i=0; $i<$count; $i++){
            for($j=$i+1; $j<$count; $j++){
                if($arr[$i]>$arr[$j]){
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$i];
                    $arr[$i] = $tmp;
                }
            }
        }
        return $arr;
    }

    /**
     * Demo for bubble sort
     *
     * Demo for binary search
     */
    public static function demo(){
        $arr = [1,3,5,2,9,10,1];
        $new = ITSP::bubbleSort($arr);
        $count = count($new);
        var_dump($new);


        $val = 5;
        print self::binarySearch($new, $val, 0, $count-1);

        $val = 7;
        print self::binaerSearchIterative($new, $val, 0, $count-1);
    }
}

ITSP::demo();
