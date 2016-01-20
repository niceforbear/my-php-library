<?php
/**
 * Created by PhpStorm.
 * User: ykliu
 * Date: 2015/8/21
 * Time: 21:12
 */

class GetAndPost{
    public static function getCommCount($url, $postId){
        $url .= "&threads={$postId}";
        $jsondata = file_get_contents($url);
        $resJson = json_decode($jsondata, true);
        return $resJson['response'][$postId]['comments'];
    }

    /**
     * Get page info by file_get_contents
     *
     * @param $url
     */
    public static function getByFileGetContents($url){
        $html = file_get_contents($url);
        return $html;
    }

    /**
     * Open url by fopen, and use get method to find data
     *
     * @param $url
     * @return string
     */
    public static function openByFopenAndGet($url){
        $fp = fopen($url, 'r');
        stream_get_meta_data($fp);
        $result = "";
        while(!feof($fp)){
            $result .= fgets($fp, 1024);
        }
        fclose($fp);
        return $result;
    }

    /**
     * Get data by post and use file_get_contents
     *
     * @param $getParam
     * @param $url
     * @return string
     */
    public static function getDataByPostAndFileGetContents($getParam, $url){
        $data = http_build_query($getParam);
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencodedrn"."Content-Length:".strlen($data).'rn',
                'content' => $data,
            ]
        ];
        $ctn = stream_context_create($opts);
        $html = file_get_contents($url, false, $ctn);
        return $html;
    }

    private static function get_url($url, $cookie = false){
        $url = parse_url($url);
        $query = $url['path'].'?'.$url['query'];
        echo 'Query:'.$query;
        $fp = fsockopen($url['host'], $url['port'] ? $url['port'] : 80, $errno, $errStr, 30);
        if(!$fp){
            return false;
        }else{
            $request = 'GET $query HTTP/1.1rn';
            $request .= "Host: {$url[host]}rn";
            $request .= 'Connection: Closern';
            if($cookie)
                $request .= 'Cookie:'.$cookie.'n';
            $request .= 'rn';
            fwrite($fp, $request);
            $result = "";
            while(!@feof($fp)){
                $result .= @fgets($fp, 1024);
            }
            fclose($fp);
            return $request;
        }
    }

    /**
     * Use fsockopen to open url, and use get method to get data, include header, body
     *
     * NOTICE: You need allow allow_url_fopen in php.ini
     *
     * @param $url
     * @param bool|false $cookie
     */
    public static function getUrlByFsockopenGet($url, $cookie = false){
        $rowData = self::get_url($url, $cookie);
        if($rowData){
            $body = stristr($rowData, 'rnrn');
            $body = substr($body, 4, strlen($body));
            return $body;
        }
        return false;
    }

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

}