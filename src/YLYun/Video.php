<?php
/**
 * 一览云视频相关
 */

namespace YLYun;
use YLYun\Exceptions\YLYunException;

class Video {

	private $client;
	public $common;
	public $params;

	public static $urls = [
		'detail' => [
			'uri' => '/video/detail',
			'keys' => ['id'],
		],
		'relate' => [
			'uri' => '/video/relation',
			'keys' => ['id'],
		],
		'play' => [
			'uri' => '/video/play',
			'keys' => ['id'],
		],
	];

	public function __construct($client) {
		$this->client = $client;
		$this->common = $this->client->getCommParams();
	}

	/**
	 * 视频详情
	 * @param string $vid 视频ID
	 * @return array
	 */
    public function videoDetail($vid) {
    	$input = array_combine(self::$urls['detail']['keys'], func_get_args());
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['detail'], $this->params);
    	$res = HTTP::get($this->client, $url);
    	if ($res['code'] == '200') {
    		unset($res['code']);
    		unset($res['msg']);
    		unset($res['logid']);
    		return $res;
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }

	/**
	 * 视频相关
	 * @param string $vid 视频ID
	 * @return array
	 */
    public function videoRelate($vid) {
    	$input = array_combine(self::$urls['relate']['keys'], func_get_args());
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['relate'], $this->params);
    	$res = HTTP::get($this->client, $url);
    	if ($res['code'] == '200' && $res['data']) {
    		return $res['data'];
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }

    /**
     * 小视频播放
     * @param string $vid 视频ID
	 * @return array
     */
    public function microVideoPlay($vid) {
    	$input = array_combine(self::$urls['play']['keys'], func_get_args());
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['play'], $this->params);
    	$res = HTTP::get($this->client, $url);
    	if ($res['code'] == '200' && $res['bitrates']) {
    		return $res['bitrates'];
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }
}