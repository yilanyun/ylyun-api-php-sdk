<?php
/**
 * 一览视频云 频道
 */

namespace YLYun;
use YLYun\Exceptions\YLYunException;

class Channel {

	private $client;
	public $common;
	public $params;

	public static $urls = [
		'channel' => [
			'uri' => '/video/getchannel',
			'keys' => [],
		],
	];

	public function __construct($client) {
		$this->client = $client;
		$this->common = $this->client->getCommParams();
	}

	//获取频道
    public function getChannel() {
    	$this->params = $this->common;
    	$url = Tools::getFullUrl(self::$urls['channel'], $this->params);
    	$res = Http::get($this->client, $url);
    	if ($res['code'] == '200' && $res['data']) {
    		return $res['data'];
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }
}