<?php
/**
 * 一览视频云 工具静态类
 */

namespace YLYun;

class Tools {

    const ENV_TEST = 'test';
    const COMM_KEYS = ['udid','brand','model','access_key','uid'];

	//计算签名
    public static function genSign($req, $data) {
    	if (empty($req) || !is_array($data)) {
        	return false;
	    }
        $token = Config::ACCESS_TOKEN;
	    $text = '';
	    ksort($data);
        $keys = array_merge(self::COMM_KEYS, $req['keys']);
	    $params = array_intersect($keys, array_keys($data));
        foreach ($data as $k => $v) {
            if (in_array($k, $params)) {
                $text .= $k . $v;
            }
        }
        $text = $req['uri'] . $text;
	    $access_token = $token . $data['timestamp'];
        $sign = base64_encode(hash_hmac("sha256", $text, $access_token, true));
        return $sign;
	}

    public static function getFullUrl($req, $data) {
        $host = Config::HOST_PROD;
        if (Config::ENV == self::ENV_TEST) {
            $host = Config::HOST_TEST;
        }
        $data['sign'] = self::genSign($req, $data);
        $url = sprintf('%s%s?%s', $host, $req['uri'], http_build_query($data));
        return $url;
    }
}


