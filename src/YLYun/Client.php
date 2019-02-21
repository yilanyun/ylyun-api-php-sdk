<?php
/**
 * 一览视频云 客户端类
 * 视频类型：
 * 短视频(video)：一般时长在1分钟左右的横版视频
 * 小视频(ugcVideo)：一般时长在10秒左右的竖版视频
 */

namespace YLYun;
use InvalidArgumentException;

class Client {

	private $_key;
	private $_token;
	private $_retryTimes;
    private $_logFile;
    public  $common = []; //通用参数
    const COMM_PARAMS = ['ip','ver','model','udid'];

	public function __construct($common, $logFile='', $retryTimes=0) {
		$this->_key = Config::ACCESS_KEY;
		$this->_token = Config::ACCESS_TOKEN;
        if (empty($this->_key) || empty($this->_token)) {
            throw new InvalidArgumentException("Invalid access_key or access_token");
        }
        //检查必要参数
        foreach (self::COMM_PARAMS as $key) {
            if (!isset($common[$key])) {
                throw new InvalidArgumentException("empty common param: {$key}");
            }
            $this->common[$key] = $common[$key];
        }
        $this->common['access_key'] = $this->_key;
        $this->common['format'] = Config::FORMAT;
        $this->common['platform'] = Config::PLATFORM;
        $this->common['timestamp'] = round(microtime(true), 3) * 1000;
		$this->_logFile = $logFile ? $logFile : Config::DEFAULT_LOG_FILE;
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
    public function getRetryTimes() {
    	return $this->_retryTimes;
    }

    //返回日志文件
    public function getLogFile() {
    	return $this->_logFile;
    }

    //获取公共参数
    public function getCommParams() {
        return $this->common;
    }
}
