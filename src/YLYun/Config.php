<?php

namespace YLYun;

class Config {

    //以下常量上线前需要修改 请咨询一览接口人索取
    const ACCESS_KEY    = 'ylx36jukc8oq';
    const ACCESS_TOKEN  = 'ow5um6c233cax89dyuaqzh3g3l4duxdx';
    const PLATFORM      = 'bjqm'; //渠道名称
    const ENV           = 'prod';  //环境 dev/prod
    const HOST_PROD     = 'https://openapiv2.yilan.tv'; //线上正式域名

    //以下常量不需要修改
	const HOST_DEV     = 'https://testapi.yilan.tv';
    const FORMAT        = 'json';
    const USER_AGENT    = 'YLYun-PHP-Client';
    const CONNECT_TIMEOUT = 5;
    const READ_TIMEOUT = 10;
    const DEFAULT_MAX_RETRY_TIMES = 2;
    const DEFAULT_LOG_FILE = "./ylyun.log";
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_OK   = '200';
}
