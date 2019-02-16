<?php
/**
 * 一览视频云 工具静态类
 */

namespace YLYun;

class Tools {

    const ENV_TEST = 'test';

	//计算签名
    public static function genSign($uri, $data) {
    	if (empty($uri) || !is_array($data)) {
        	return false;
	    }
        $token = Config::ACCESS_TOKEN;
	    $text = $uri;
	    ksort($data);
        foreach ($data as $k => $v) {
            $text .= $k . $v;
        }
	    $access_token = $token . $data['timestamp'];
        $sign = base64_encode(hash_hmac("sha256", $text, $access_token, true));
        return $sign;
	}

    public static function getFullUrl($uri, $data) {
        $host = Config::HOST_PROD;
        if (Config::ENV == self::ENV_TEST) {
            $host = Config::HOST_TEST;
        }
        $data['sign'] = self::genSign($uri, $data);
        $url = sprintf('%s%s?%s', $host, $uri, http_build_query($data));
        return $url;
    }
}


