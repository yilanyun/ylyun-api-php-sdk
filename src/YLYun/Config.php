<?php

namespace YLYun;

class Config
{
    //以下常量上线前需要修改 请咨询一览接口人索取
    const ACCESS_KEY = '';
    const ACCESS_TOKEN = '';
    const ENV = 'prod';  //环境 dev/prod

    //以下常量不需要修改
    const HOST_PROD = 'https://videoapis.yladm.com'; //线上正式域名
    const HOST_DEV = 'http://testapi.yladm.com';
    const USER_AGENT = 'YLYun-PHP-Client';
    const CONNECT_TIMEOUT = 5;
    const READ_TIMEOUT = 10;
    const DEFAULT_MAX_RETRY_TIMES = 2;
    const DEFAULT_LOG_FILE = "./ylyun.log";
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_OK = '200';
}
