<?php
/**
 * 一览视频云 工具静态类
 */

namespace YLYun;

class Tools
{

    const ENV_TEST = 'dev';

    //计算签名
    public static function genSign($uri, $data)
    {
        if (empty($uri) || !is_array($data)) {
            return false;
        }
        $token = Config::ACCESS_TOKEN;
        $text  = $uri;
        ksort($data);
        foreach ($data as $k => $v) {
            $text .= $k . $v;
        }
        $access_token = $token . $data['timestamp'];
        $sign         = base64_encode(hash_hmac("sha256", $text, $access_token, true));
        return $sign;
    }

    public static function api($uri, $client, $params)
    {
        $url    = static::getUrl($uri);
        $header = static::getHeader($client);
        $body   = static::getBody($client, $params);
        $res    = Http::post($client, $url, $body, $header);
        if ($res['retcode'] == '200' && $res['data']) {
            $data = AES::decrypt(Config::ACCESS_TOKEN, $res['data']);
            $res['data'] = json_decode($data, true);
        }
        return $res;
    }

    public static function getUrl($uri)
    {
        $host = Config::HOST_PROD;
        if (Config::ENV == self::ENV_TEST) {
            $host = Config::HOST_DEV;
        }

        $url = sprintf('%s%s', $host, $uri);
        return $url;
    }

    /**
     * @param $client \YLYun\Client
     * @return array
     */
    public static function getHeader($client)
    {
        return [
            'X-YL-KEY: ' . Config::ACCESS_KEY,
            'X-YL-TIMESTAMP: ' . $client->getTimestamp(),
        ];
    }

    /**
     * 获取请求body
     * @param $client \YLYun\Client
     * @param $params
     * @return array
     */
    public static function getBody($client, $params)
    {
        $encryptParams = AES::encrypt(Config::ACCESS_TOKEN, json_encode($params));
        $sign          = static::getSign($client, $encryptParams);
        return [
            'access_key' => Config::ACCESS_KEY,
            'params'     => $encryptParams,
            'timestamp'  => $client->getTimestamp(),
            'sign'       => $sign,
        ];
    }

    /**
     * 获取签名
     * @param $client \YLYun\Client
     * @param $text
     * @return string
     */
    public static function getSign($client, $text)
    {
        $hmacKey = Config::ACCESS_TOKEN . $client->getTimestamp();
        $sign    = base64_encode(hash_hmac("sha256", $text, $hmacKey, true));
        return $sign;
    }

}


