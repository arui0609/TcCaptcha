<?php
/**
 *
 * User: songrui
 * Date: 2022/11/25
 * Email: <sr_yes@foxmail.com>
 */
namespace Arui\TcCaptcha;

trait Request
{
    /**
     * @param $url
     * @param null $data
     * @param string $method
     * @param bool $is_string
     * @param array $headers
     * @return bool|string|null
     */
    public static function curl_client($url, $data=null, $method = 'GET' ,$is_string=false,$headers=[]){
        $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_URL =>$url
        );
        $method = strtoupper($method);
        if($method =='GET'){
            $opts[CURLOPT_URL] = $url . (is_array($data) ? '?' . http_build_query($data) :'');
        }else{
            switch ($method){
                case "POST":
                    $opts[CURLOPT_POST] = 1;
                    break;
                case "PUT" :
                    $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
                    break;
                case "PATCH":
                    $opts[CURLOPT_CUSTOMREQUEST] = 'PATCH';
                    break;
                case "DELETE":
                    $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                    break;
            }
            if(is_string($data)){ //发送JSON数据
                $headers[]='Content-Type: application/json; charset=utf-8';
                $headers[]='Content-Length: ' . strlen($data);
            }
            $opts[CURLOPT_POSTFIELDS] = $is_string ? http_build_query($data) :$data;
        }
        $opts[CURLOPT_HTTPHEADER] = $headers;

        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error) return false;
        return  $data;
    }
}
