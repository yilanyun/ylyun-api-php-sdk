<?php
/**
 * 一览视频云 工具静态类
 */

namespace YLYun;

class Tools {

	//计算签名
    public static function genSign($data, $token) {
    	if (!is_array($data) || !$token) {
        	return false;
	    }
	    ksort($data);
	    $data['access_token'] = $token;
	    $hash = [];
	    foreach ($data as $k => $v) {
	        $hash[] = "{$k}={$v}";
	    }
	    $str = implode('&', $hash);
	    return md5($str);
	}


}