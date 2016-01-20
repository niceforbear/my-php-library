<?php
/* 
 * This file created for an urgent task which aim to deal with a mussy XLS file.
 * Filtering some useful strings. 
 */

header("Content-type: text/html; charset=gbk");
$source = [];
$handle = @fopen("mission.csv","r");
if($handle){
    while(($buffer = fgets($handle,79809)) !== false){//Get 79809 chars manually
        $source[] = $buffer;
    }
}
foreach($source as $k => $v){
    $source[$k] = preg_replace('/\r|\n/', '', $v);
}
$num = count($source);
$result = array();
$num = 5;
$source2 = $source;
$count = 0;

for($i=0;$i<$num;$i++){
    for($j=$i;$j<$num;$j++){
        similar_text($source[$i],$source2[$j],$p);
        $result[$i][$j] = round($p);
        if($result[$i][$j] >= 50)
            $count ++;
    }
}
echo $count;
$count = 0;
$temp_source = [];
$temp_tran = [];

for($i=0;$i<$num;$i++){
    echo $source[$i];
    $temp_source = str_split($source[$i]);
    echo $temp_source;
    for($j=$i;$j<$num;$j++){
        $temp_tran = str_split($source[$j]);
        echo $source[$j];
        echo $temp_tran;
        $mixed = array_intersect($temp_source,$temp_tran);
        echo $mixed;
        if(count($mixed) == min(count($temp_source),count($temp_tran)))
            $result[$i][$j] = 100;
        if($result[$i][$j] >= 50)
            $count ++;
    }
}
echo $count;

function prettyDump($varVal,$isExit = false){
    ob_start();
    var_dump($varVal);
    $varVal = ob_get_clean();
    $varVal = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $varVal);
    echo '<pre>'.$varVal.'</pre>';
    $isExit && exit();
}

?>