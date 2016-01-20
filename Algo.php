<?php

/**
 * Some algorithms
 *
 * @author niceforbear
 * @date 2015/09/15 11:05
 */
class Algo{

    /**
     * Sort algorithm: quick sort by recursion
     *
     * @param $array array one-dimensional array
     * @return array sorted array
     */
    public static function quickSortByRecursion($array = []){
        if(count($array) <= 1)
            return $array;
        $key = $array[0];
        $leftArr = [];
        $rightArr = [];
        $_size = count($array);
        for($i = 1; $i < $_size; $i++){
            if($array[$i] <= $key){
                $leftArr[] = $array[$i];
            }else{
                $rightArr[] = $array[$i];
            }
        }
        $leftArr = self::quickSortByRecursion($leftArr);
        $rightArr = self::quickSortByRecursion($rightArr);
        return array_merge($leftArr,array($key),$rightArr);
    }

    /**
     * Sort algorithm: quick sort by iteration
     *
     * @param $array array
     * @return array
     */
    public static function quickSortByIteration($array){
        if(count($array) <= 1)
            return $array;
        $stack = array($array);//Construct 2-d array
        $sort = [];
        while($stack){
            $popArr = array_pop($stack);
            if(count($popArr) <= 1){//Find the min in the temporary array `$stack`, so pop and store it.
                if(count($popArr) == 1){
                    $sort[] = $popArr[0];
                }
                continue;
            }
            $key = $popArr[0];//Rand get a value
            $left = [];
            $right = [];
            $_size = count($popArr);
            for($i = 1; $i < $_size; $i++){
                if($popArr[$i] <= $key){
                    $left[] = $popArr[$i];
                }else{
                    $right[] = $popArr[$i];
                }
            }
            /**
             * Left and right are both array and put them into array, only the key is an element.
             * Because it use `the pop` method, so push right first and left second,
             * so it could pop the min element firstly and put it into `sort` array.
             */
            !empty($right) && array_push($stack, $right);
            array_push($stack,array($popArr[0]));
            !empty($left) && array_push($stack, $left);
        }
        return $sort;
    }

    /**
     * Example for quick sort
     */
    public static function testForQuickSortByIteration(){
        $testArr = [];
        for($i = 0; $i < 8; $i++){
            $testArr[] = mt_rand(0,100);
        }
        print_r($testArr);
        echo "<br>";
        print_r(self::quickSortByRecursion($testArr));
        echo "<br>";
        print_r(self::quickSortByIteration($testArr));
        echo "<br>";
    }

    /**
     * To find the kth smallest element in an unordered list.
     */
    public static function quickSelect($array){

    }

    /**
     * Used for quickSelect
     */
    private static function partition($list, $left, $right, $pivotIndex){
//        $pivotValue = $list[];
    }
}

Algo::testForQuickSortByIteration();
?>