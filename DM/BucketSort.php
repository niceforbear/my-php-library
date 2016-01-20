<?php

/**
 * Created by PhpStorm.
 * User: liuyinkuo
 * Date: 16/1/17
 * Time: 下午3:25
 */

/**
 * Class BucketSort
 *
 */
class BucketSort
{
    public static function sort($arr){
        $buckets = []; // initial bucket
        for($i=0;$i<10;$i++){
            $buckets[$i] = [];
        }

        foreach($arr as $item){
            $heel = $item % 10;
            $buckets[$heel][] = $item;
        }

        foreach($buckets as $k => $bucket){
            foreach($bucket as $index => $item){
                if($item % 10 == $k){ // 这个item属于这个bucket中
                    $heel = ($item - $k) / 10 % 10;
                    $buckets[$heel][] = $item;
                    unset($buckets[$k][$index]);
                }
            }
        }

        foreach($buckets as $k => $bucket){
            foreach($bucket as $index => $item){
                if( intval(($item % 100) / 10) == $k){
                    $heel = intval($item / 100);
                    $buckets[$heel][] = $item;
                    unset($buckets[$k][$index]);
                }
            }
        }

        $sorted = [];

        foreach($buckets as $bucket){
            foreach($bucket as $item){
                if(isset($item)){
                    $sorted[] = $item;
                }
            }
        }
        return $sorted;
    }

    public static function test(){
        $arr = [];
        for($i=0;$i<10;$i++){
            $arr[] = rand(0,999);
        }
        shuffle($arr);
//        $arr = [460, 104, 202, 30, 580, 400, 604, 862, 712, 309];
        print_r($arr);
        $sortedArr = BucketSort::sort($arr);
        print_r($sortedArr);
    }
}
BucketSort::test();