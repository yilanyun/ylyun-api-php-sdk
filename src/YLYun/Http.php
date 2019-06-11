<?php

namespace YLYun;

use YLYun\Exceptions\APIConnectionException;

final class Http
{

    public static function get($client, $url)
    {
        $response = self::sendRequest($client, $url, Config::HTTP_GET, $body = null);
        return $response;
    }

    public static function post($client, $url, $body, $header = [])
    {
        $response = self::sendRequest($client, $url, Config::HTTP_POST, $body, $header);
        return $response;
    }

    private static function sendRequest($client, $url, $method, $body = null, $header = [], $times = 1)
    {
        self::log($client, "Send " . $method . " " . $url . ", body:" . json_encode($body) . ", times:" . $times);
        if (!defined('CURL_HTTP_VERSION_2_0')) {
            define('CURL_HTTP_VERSION_2_0', 3);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, Config::CONNECT_TIMEOUT);  // 连接建立最长耗时
        curl_setopt($ch, CURLOPT_TIMEOUT, Config::READ_TIMEOUT);  // 请求最长耗时
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //不验证否设置域名
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        // 设置Post参数
        if ($method === Config::HTTP_POST) {
            curl_setopt($ch, CURLOPT_POST, true);
        }
        if (is_array($body)) {
            // $data = http_build_query($body);
            $data = json_encode($body);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $output    = curl_exec($ch);
        $errorCode = curl_errno($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($errorCode !== 0 || 200 != $httpCode) {
            $retries = $client->getRetryTimes();
            if ($times < $retries) {
                return self::sendRequest($client, $url, $method, $body, $header, ++$times);
            }
            if ($errorCode === 28) {
                throw new APIConnectionException("Response timeout", $errorCode);
            } elseif ($errorCode === 56) {
                throw new APIConnectionException("Response timeout, maybe cause by old CURL version", $errorCode);
            } else {
                throw new APIConnectionException("Connect timeout", $errorCode);
            }
        }
        curl_close($ch);
        $res = json_decode($output, true);
        return $res;
    }

    public static function log($client, $content)
    {
        if (!is_null($client->getLogFile())) {
            error_log($content . "\r\n", 3, $client->getLogFile());
        }
    }
}
