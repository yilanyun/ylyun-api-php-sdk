<?php
/**
 * 一览云内容推荐
 */

namespace YLYun;
use YLYun\Exceptions\YLYunException;

class Recommend {

	private $client;
	public $common;
	public $params;

	public static $urls = [
		'feed' => '/video/feed',
		'ugc_feed' => '/video/ugcfeed',
	];

	public function __construct($client) {
		$this->client = $client;
		$this->common = $this->client->getCommParams();
	}

	/**
	 * 频道推荐列表
	 * @param  string $uid  用户唯一标识
	 * @param  int $load_type  0-上拉加载更多 1-非首次下拉刷新时 2-首次刷新某个频道
	 * @param  string] $channel_id 频道id
	 * @param  string] $log_id 接口请求唯一标识
	 * @return array  推荐数据
	 */
    public function recommendFeed($uid, $load_type, $channel_id, $log_id) {
    	$input = [
    		'uid' => $uid,
    		'load_type' => $load_type,
    		'channel_id' => $channel_id,
    		'log_id' => $log_id,
    	];
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['feed'], $this->params);
    	$res = Http::get($this->client, $url);
    	if ($res['code'] == '200' && $res['data']) {
    		return $res['data'];
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }

    /**
     * 小视频推荐列表
	 * @param  int $load_type  0-上拉加载更多 1-非首次下拉刷新时 2-首次刷新某个频道
	 * @param  string] $log_id 接口请求唯一标识
	 * @return array  推荐数据
     */
    public function recommendUgcFeed($load_type, $log_id) {
    	$input = [
    		'load_type' => $load_type,
    		'log_id' => $log_id,
    	];
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['ugc_feed'], $this->params);
    	$res = Http::get($this->client, $url);
    	if ($res['code'] == '200' && $res['data']) {
    		return $res['data'];
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }
}