<?php
/**
 *
 * User: songrui
 * Date: 2022/11/25
 * Email: <sr_yes@foxmail.com>
 */
namespace Arui\TcCaptcha;

class TcCaptcha
{
    use Request;

    public $secret_id;

    public $secret_key;

    public $CaptchaAppId;

    public $AppSecretKey;

    public function DescribeCaptchaResult($Ticket, $Randstr, $UserIp)
    {
        if (!$Ticket) {
            throw new \Exception("miss ticket");
        }
        if (!$Randstr) {
            throw new \Exception("miss randstr");
        }
        $host = "captcha.tencentcloudapi.com";
        $data = [
            'Action' => 'DescribeCaptchaResult',
            'Version' => '2019-07-22',
            'CaptchaType' => '9',
            'Ticket' => $Ticket,
            'UserIp' => $UserIp,
            'Randstr' => $Randstr,
            'CaptchaAppId' => $this->CaptchaAppId,
            'AppSecretKey' => $this->AppSecretKey,
            'NeedGetCaptchaTime' => 1
        ];

        $data = array_merge($data, $this->getCommonParam());
        $data['Signature'] = $this->getSignature($data, $host);
        $url = "https://{$host}/?" . http_build_query($data);
        $res = json_decode($this->curl_client($url), true);

        if ($res['retmsg'] == 'success' && $res['Response']['CaptchaCode'] == 1) {
            if ((time() - $res['Response']['GetCaptchaTime']) > 30) {
                throw new \Exception("ticket校验接口超时");
            }
            return true;
        } else {
            throw new \Exception($res['Response']['CaptchaMsg']);
        }
    }

    public function __construct()
    {
        $this->secret_id = config('qq_captcha.secret_id');
        $this->secret_key = config('qq_captcha.secret_key');
        $this->CaptchaAppId = config('qq_captcha.secret_appid');
        $this->AppSecretKey = config('qq_captcha.secret_appkey');
    }

    protected function getSignature($data, $host)
    {
        ksort($data);
        $str = '';
        foreach ($data as $key => $datum) {
            $str .= $key . '=' . $datum . '&';
        }
        $str = substr($str, 0, -1);
        $str = "GET{$host}/?{$str}";
        return base64_encode(hash_hmac('sha1', $str, $this->secret_key, true));
    }

    protected function getCommonParam()
    {
        return [
            'Timestamp' => time(),
            'Nonce' => mt_rand(100000, 999999),
            'SecretId' => $this->secret_id
        ];
    }

}
