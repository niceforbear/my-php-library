<?php

/**
 * Created by PhpStorm.
 * User: niceforbear
 * Date: 15/12/22
 * Time: 上午1:06
 */
class ITSP
{
    public static function mergeSort($arr){
        if(count($arr) == 1){
            return $arr;
        }

        $left = $right = [];
        $middle = round(count($arr)/2);
        for($i=0; $i<$middle; $i++){
            $left[] = $arr[$i];
        }
        for($i=$middle; $i<count($arr); $i++){
            $right[] = $arr[$i];
        }

        $left  = ITSP::mergeSort($left);
        $right = ITSP::mergeSort($right);
        return ITSP::mergeSortConquer($left, $right);
    }

    public static function mergeSortConquer($left, $right){
        $result = [];

        while(count($left) > 0 || count($right) > 0){
            if(count($left) > 0 && count($right) > 0){
                $firstLeft  = current($left);
                $firstRight = current($right);
                if($firstLeft < $firstRight){
                    $result[] = array_shift($left);
                }else{
                    $result[] = array_shift($right);
                }
            }elseif(count($left) > 0){
                $result[] = array_shift($left);
            }elseif(count($right) > 0){
                $result[] = array_shift($right);
            }
        }

        return $result;
    }

    public static function insertSort($arr){
        $count = count($arr);
        for($i=0; $i<$count; $i++){
            $temp = $arr[$i];
            for($j=$i-1; $j>=0&&$arr[$j]>$temp; $j--){
                $arr[$j+1] = $arr[$j];
            }
            $arr[$j+1] = $temp;
        }
        return $arr;
    }

    public static function selectSort($arr){
        $count = count($arr);
        for($i=0; $i<$count; $i++){
            $min = $arr[$i];
            for($j=$i+1; $j<$count; $j++){
                if($min > $arr[$j]){
                    $tmp = $arr[$i];
                    $arr[$i] = $arr[$j];
                    $arr[$j] = $tmp;
                }
            }
        }
        return $arr;
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
        /**
         * Demo data:
         *
         * $arr = [];
         * for($i=0; $i<100; $i++)
         *   $arr[] = $i;
         * shuffle($arr);
         */

        $arr = [1,3,5,2,9,10,1];

        $new = ITSP::mergeSort($arr);
        var_dump($new);
        exit;

        $new = ITSP::insertSort($arr);
        var_dump($new);
        exit;

        $new = ITSP::selectSort($arr);
        var_dump($new);
        exit;

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
