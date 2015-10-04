<?php

/**
 * @desc My function tools kit.
 *
 * @author niceforbear
 * @date 2015/08/03 13:36
 *
 */

class Toys{

    /**
     * Build for Karate rank TblUtil
     *
     * Example:
     * Input : 465827476535250944
     * Output: 70
     *
     * @time 2015/08/30 21:45
     *
     * @param $uuid
     * @param string $mod Mod for cut table
     * @return string
     */
    public static function rankConvert($uuid, $mod = "128"){
        $binaryString = self::convertDecimal2Binary($uuid);
        $binaryString = substr($binaryString, 0, strlen($binaryString) - 22);
        $decimal = self::convertBinary2Decimal($binaryString);
        $result = bcmod($decimal, $mod);
        return $result;
    }

    /**
     * Convert binary to decimal
     *
     * @time 2015/08/30 21:45
     *
     * @param string $binaryString
     * @param string $base
     * @return string
     */
    public static function convertBinary2Decimal($binaryString = "", $base = "2"){
        if(empty($binaryString) || !is_string($binaryString)){
            return false;
        }
        $binaryString = strrev($binaryString);
        $decimalSum = "0";
        bcscale(0);
        $i = "0";
        while(true){
            if(empty($binaryString)){
                break;
            }
            $strTmp = substr($binaryString, 0, 1);
            $baseTmp = bcpow($base, $i);
            $i = (string)((int)$i + 1);
            $addTmp = bcmul($strTmp, $baseTmp);
            $decimalSum = bcadd($decimalSum, $addTmp);
            $binaryString = substr($binaryString, 1);
        }
        return $decimalSum;
    }

    /**
     * Convert decimal number as a string to binary number
     * For TblUtil in Karate rank
     *
     * Example:
     * Input:  string $uuid = "465827479475458048";
     * Output: string 10101001111100111001111111100000110000000001000000000000
     *
     * @time 2015/08/30 21:45
     *
     * @param $uuid string
     * @param $base string The convert base
     * @return bool
     */
    public static function convertDecimal2Binary($uuid = "", $base = "2"){
        if(empty($uuid) || bccomp($uuid, "0", 0) <= 0){
            return false;
        }
        $binaryResult = "";
        bcscale(0);//Set the default precision
        $intBase = (int)$base;
        while(true){
            if(substr_compare($uuid, "0", 0) == 0){
                break;
            }
            $last = substr($uuid, -1);//Get the last number
            $divFlag = 0;
            if($last % $intBase == 0){//If $uuid could be divisible
                $binaryResult .= "0";
            }else{
                $binaryResult .= "1";
                $divFlag = 1;
            }
            if($divFlag == 1){
                $lastTwo = substr($uuid, -2);
                $replace = (string)((int)$lastTwo - 1);
                $uuid = substr_replace($uuid, $replace, -2);
            }
            $uuid = bcdiv($uuid, $base);
        }
        $binaryResult = strrev($binaryResult);//Reversing the binary sequence to get the right result
        return $binaryResult;
    }

    /**
     * The function which could help bro manyang to operate ditui, clear dirty data;
     *
     * @param $selectTableName string Table name of export table of database
     * @param $insertTableName string Table name of import table of database
     * @param string $sqlStr Columns and condition
     * @param string $writeFileName Write to a file
     * @param $csvFileName string
     * @param string|int $csvFileLines Csv file lines, *NOTICE* there must be no empty lines at the end of the file
     * @param string $sqlWhereSubString Need abluented sub string in csv file
     * @return bool
     */
    public static function csv_to_insert_sql($selectTableName, $insertTableName, $sqlStr = "1=1", $writeFileName = "insertSQL.sql", $csvFileName, $csvFileLines = '100', $sqlWhereSubString=""){
        $fp = fopen("$writeFileName",'r');
        if($fp){
            echo "file exists";
            return false;
        }
        $file = self::csv_get_lines($csvFileName, $csvFileLines);
        $cleanTable = [];
        foreach($file as $k => $item){
            /** Replace substring, assembling right format */
            $item[0] = strtr($item[0],["rrtaudit:"=>""]);
            $cleanTable[] = (int)$item[0];
        };
        /** Assembing where clause in SQL statement */
        $whereStr = "(";
        foreach($cleanTable as $k => $v){
            $whereStr .=$v;
            if($k < $csvFileLines - 2)
                $whereStr .= ",";
        }
        $whereStr .= ")";

        $conn = mysql_connect("localhost","root","liuyinkuo") or die(mysql_error());
        $db = mysql_select_db("ditui",$conn) or die(mysql_error());
        $selectSql = "SELECT * FROM $selectTableName WHERE $sqlWhereSubString AND audit_id NOT IN {$whereStr}";
        $res = mysql_query($selectSql, $conn);

        $ctn = [];
        while($row = mysql_fetch_array($res))
        {
            $ctn[] = $row;
        }
        mysql_close($conn);

        $insertSql = "INSERT INTO `{$insertTableName}` (`$sqlStr`) VALUES ";
        foreach($ctn as $i => $item){
            $insertSql .= "('{$ctn[0]}')\n";
            if($i < count($ctn)-1)
                $insertSql .= ",";
        }
        $insertSql .= ";";

        $fp = fopen("$writeFileName","w");
        $writeCharNum = fwrite($fp,$insertSql) or die(mysql_error());
        echo "write chars number: ". $writeCharNum;
        fclose($fp);
    }

    /**
     * Read a csv file by line;
     *
     * @param $csvfile string Csv file name;
     * @param int $lines Provide batch work function, select $lines lines of csv file;
     * @param int $offset Cooperate with batch work function, start from $offset;
     * @return array|bool
     */
    public static function csv_get_lines($csvfile, $lines = 100, $offset = 0){
        $lines = $lines -1;
        if(!$fp = fopen($csvfile, 'r')){
            return false;
        }
        $i = $j = 0;
        while(($line = fgets($fp)) !== false){
            if($offset > $i++){
                continue;
            }
            break;
        }
        $data = [];
        while( ($j++ < $lines) && !feof($fp) ){
            $data[] = fgetcsv($fp);
        }
        fclose($fp);
        return $data;
    }

    /**
     * @desc sort array by its one field name.
     *
     * @param $array array which need be ordered.
     * @param $col_name string field name
     * @param bool|true $asc order
     * @return array ordered $array
     */
    public static function arraySortortByKey($array, $col_name, $asc = true){
        $index = [];
        foreach($array as $k=>$v){
            $index[] = $v[$col_name];
        }
        $order = '';
        if($asc === true){
            $order = SORT_ASC;
        }elseif($asc === false){
            $order = SORT_DESC;
        }else{
            return false;
        }
        array_multisort($index, $order, $array);
        return $array;
    }

    /**
     * @desc pretty var_dump the mixed content.
     *
     * @param $varVal mixed dumped content.
     * @param bool|false $isExit if the program over at the end of the function.
     */
    public static function prettyDump($varVal,$isExit = false){
        ob_start();
        var_dump($varVal);
        $varVal = ob_get_clean();
        $varVal = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $varVal);
        echo '<pre>'.$varVal.'</pre>';
        $isExit && exit();
    }

    /**
     * Upgrade of last function
     *
     * @param $varVal
     * @param string $diff
     * @param bool|false $isExit
     */
    public static function prettyDumpDiff($varVal, $diff="Diff", $isExit = false){
        ob_start();
        var_dump($varVal);
        $varVal = ob_get_clean();
        $varVal = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $varVal);
        $str = "   ===============   ";
        echo "<pre><br>\n".$str.$diff.$str."<br>\n".$varVal."<br>\n".$str.$diff.$str."<br>\n".'</pre>';
        $isExit && exit();
    }

    /**
     * @desc   通过curl模拟post
     * @param  string $url curl处理的url
     * @param  array  $content curl要post处理的内容
     * @return array
     */
    public static function curlPost($url,$content){
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER  => false,
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT => 120,          // timeout on response
            CURLOPT_MAXREDIRS => 10,           // stop after 10 redirects
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => $content,
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
	
	/**
	 * Filter
	 * Demo:
	 * $file = 'spam.txt';
	 * $str = 'This string has  cat, dog word';
	 * if(isSpam($str, $file))
	 * 		echo 'this is spam';
	 */
	public static function isSpam($text, $file, $split=':', $regex = false){
		$handle = fopen($file,'rb');
		$contents = fread($handle, filesize($file));
		fclose($handle);
		$lines = explode('n',$contents);// Set this rule
		$arr = [];
		foreach($lines as $line){
			list($word, $count) = explode($split, $line);
			if($regex){
				$arr[$word] = $count;
			}else{
				$arr[preg_quote($word)] = $count;
			}
		}
		preg_match_all("~".implode('|',array_keys($arr))."~", $text, $matches);
		$temp = [];
		foreach($matches[0] as $match){
			if(!in_array($match, $temp)){
				$temp[$match] = $temp[$match] + 1;
				if($temp[$match] >= $arr[$word])
					return true;
			}
		}
		return false;
	}
	
	/**
	 * Generate random color 
	 */
	public static function randomColor(){
		$str = '#';
		for($i = 0; $i < 6; $i++){
			$randNum = rand(0, 15);
			switch($rankNum){
				case 10: $randNum = 'A'; break;
				case 11: $randNum = 'B'; break;
				case 12: $randNum = 'C'; break;
				case 13: $randNum = 'D'; break;
				case 14: $randNum = 'E'; break;
				case 15: $randNum = 'F'; break;
			}
			$str .= $randNum;
		}
		return $str;
	}
	
	
}
?>