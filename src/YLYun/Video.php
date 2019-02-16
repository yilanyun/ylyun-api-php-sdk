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
		'detail' => '/video/detail',
		'relate' => '/video/relation',
		'play' => '/video/play',
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
    	$input['id'] = $vid;
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['detail'], $this->params);
    	$res = Http::get($this->client, $url);
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
    	$input['id'] = $vid;
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['relate'], $this->params);
    	$res = Http::get($this->client, $url);
    	if ($res['code'] == '200' && $res['data']) {
    		return $res['data'];
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }

    /**
     * 视频播放
     * @param string $vid 视频ID
	 * @return array
     */
    public function videoPlay($vid) {
    	$input['id'] = $vid;
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['play'], $this->params);
    	$res = Http::get($this->client, $url);
    	if ($res['code'] == '200' && $res['bitrates']) {
    		return $res['bitrates'];
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }
}