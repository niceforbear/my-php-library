<?php
/**
 * Sorting class
 *
 * @author niceforbear
 * @date 2015/08/29 22:20
 */
class Sort{
    /**
     * Merge sorting
     *
     * Eg:
     * $input  = [6,5,3,1,8,7,2,4];
     * $output = Sort::merge_sort($input);
     *
     * @param $arr array
     * @return array array
     */
    public static function merge_sort($arr){
        if(count($arr) <= 1){
            return $arr;
        }
        $left = array_slice($arr, 0, (int)(count($arr)/2));
        $right = array_slice($arr,(int)(count($arr)/2));

        $left = self::merge_sort($left);
        $right = self::merge_sort($right);

        $output = self::merge($left, $right);
        return $output;
    }

    private static function merge($left, $right){
        $result = [];
        while(count($left) > 0 && count($right) > 0){
            if($left[0] <= $right[0]){
                array_push($result, array_shift($left));//array_shift help the array move forward one step.
            }else{
                array_push($result, array_shift($right));
            }
        }
        /** 最后 $left || $right 会剩余一个元素，需要push到 $result, 这样写不需要判断，直接替换，更加快捷 */
        array_splice($result, count($result), 0, $left);//Replace $result's elements from count($result) to count($result)+0 as $left
        array_splice($result, count($result), 0, $right);
        return $result;
    }
}