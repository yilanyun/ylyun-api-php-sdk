<?php

namespace YLYun;

class Config {

    //以下常量上线前需要修改 请咨询一览接口人索取
    const ACCESS_KEY    = '';
    const ACCESS_TOKEN  = '';
    const PLATFORM      = ''; //渠道名称
    const HOME_CHAN_ID  = '';  //首页频道ID
    const ENV           = 'test'; //环境test/prod
    const HOST_PROD     = ''; //线上正式域名

    //以下常量不需要修改
	const HOST_TEST     = 'https://testapi.yilan.tv';
    const FORMAT        = 'json';
    const USER_AGENT    = 'YLYun-PHP-Client';
    const CONNECT_TIMEOUT = 1;
    const READ_TIMEOUT = 5;
    const DEFAULT_MAX_RETRY_TIMES = 2;
    const DEFAULT_LOG_FILE = "./ylyun.log";
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_OK   = '200';
}
