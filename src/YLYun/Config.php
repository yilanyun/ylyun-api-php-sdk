<?php

namespace YLYun;

class Config {

	//环境 test/prod
	const ENV           = 'prod';
	const HOST_TEST     = 'https://testapi.yilan.tv';
	const HOST_PROD     = 'https://openapiv2.yilan.tv';

	//key和token需要接入时一览提供
    const ACCESS_KEY 	= '';
    const ACCESS_TOKEN  = '';
    const PLATFORM      = '';
    const FORMAT        = 'json';
    //精选频道ID
    const HOME_CHAN_ID  = '100';

    const USER_AGENT    = 'YLYun-PHP-Client';
    const CONNECT_TIMEOUT = 1;
    const READ_TIMEOUT = 5;
    const DEFAULT_MAX_RETRY_TIMES = 2;
    const DEFAULT_LOG_FILE = "./ylyun.log";
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_OK   = '200';
}
