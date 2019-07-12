<?php
/**
 * 一览视频云 客户端类
 * 视频类型：
 * 短视频(video)：一般时长在1分钟左右的横版视频
 * 小视频(ugcVideo)：一般时长在10秒左右的竖版视频
 */

namespace YLYun;

use InvalidArgumentException;

class Client
{
    private $_key;
    private $_token;
    private $_retryTimes;
    private $_logFile;
    public $timestamp;
    public $common = []; //通用参数
    protected $needParams = [
        'udid',        // 设备唯一标识，客户端生成
        'sver',        // 服务端版本
        'prid',        // 区分请求接口来源（api 默认填 19）
        'ip',          // 客户端ip地址
        'ver',         // 客户端版本
        'mac',         // 设备mac地址，限于Android
        'imei',        // 设备imei，限于Android
        'imeimd5',     // 设备imei脱敏信息，imei采用md5方式处理
        'idfa',        // 设备idfa，限于iOS
        'model',       // 设备型号
        'brand',       // 设备厂商
        "adid",        // Android ID，字母大写
        'nt',          // 客户端网络环境
        'telecom',     // 客户端运营商
        'os_ver',      // 客户端操作系统版本
        'pkg_name',    // 应用包名
    ];

    public function __construct($common, $logFile = '', $retryTimes = 0)
    {
        $this->_key      = Config::ACCESS_KEY;
        $this->_token    = Config::ACCESS_TOKEN;
        $this->timestamp = round(microtime(true), 3) * 1000;

        if (empty($this->_key) || empty($this->_token)) {
            throw new InvalidArgumentException("Invalid access_key or access_token");
        }
        //检查必要参数
        foreach ($this->needParams as $key) {
            if (!isset($common[$key])) {
                throw new InvalidArgumentException("empty common param: {$key}");
            }
            $this->common[$key] = $common[$key];
        }
//        $this->common['access_key'] = $this->_key;
//        $this->common['timestamp'] = round(microtime(true), 3) * 1000;
        $this->_logFile    = $logFile ? $logFile : Config::DEFAULT_LOG_FILE;
        $this->_retryTimes = $retryTimes ? $retryTimes : Config::DEFAULT_MAX_RETRY_TIMES;
    }

    //频道模块
    public function channel() { return new Channel($this); }

    //推荐模块
    public function recommend() { return new Recommend($this); }

    //视频模块
    public function video() { return new Video($this); }

    //搜索模块
    public function search() { return new Search($this); }

    //返回重试次数
    public function getRetryTimes()
    {
        return $this->_retryTimes;
    }

    //返回日志文件
    public function getLogFile()
    {
        return $this->_logFile;
    }

    //获取公共参数
    public function getCommParams()
    {
        return $this->common;
    }

    //获取请求时间戳
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
