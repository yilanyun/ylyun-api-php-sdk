<?php
/**
 * 一览云搜索相关
 */

namespace YLYun;

class Search {

	private $client;
	public $common;
	public $params;

	public static $urls = [
		'search' => '/video/search',
	];

	public function __construct($client) {
		$this->client = $client;
		$this->common = $this->client->getCommParams();
	}

	/**
	 * 搜索视频
	 * @param string $keyword 关键词
	 * @return array 视频列表
	 */
    public function searchVideo($keyword) {
    	$input['key'] = trim($keyword);
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['search'], $this->params);
    	$res = Http::get($this->client, $url);
    	if ($res['code'] == '200' && $res['data']) {
    		return $res['data'];
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }
}