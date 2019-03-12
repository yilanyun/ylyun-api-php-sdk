<?php
/**
 * 一览云内容推荐
 */

namespace YLYun;
use YLYun\Exceptions\YLYunException;
use YLYun\Params\FeedWithAdParam;

class Recommend {

	private $client;
	public $common;
	public $params;

	public static $urls = [
		'feed' => '/video/feed',
		'ugc_feed' => '/video/ugcfeed',
        'feed_with_ad' => '/video/feedwithad'
	];

	public function __construct($client) {
		$this->client = $client;
		$this->common = $this->client->getCommParams();
	}

	/**
	 * 频道推荐列表
	 * @param  int $load_type  0-上拉加载更多 1-非首次下拉刷新时 2-首次刷新某个频道
	 * @param  string $channel_id 频道id
     * @param  string $uid  用户唯一标识
	 * @return array  推荐数据
     * @throws YLYunException
	 */
    public function recommendFeed($load_type, $channel_id, $uid = '0') {
    	$input = [
    		'load_type' => $load_type,
    		'channel_id' => $channel_id,
    		'uid' => $uid,
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
	 * @param  string $uid  用户唯一标识
	 * @return array  推荐数据
     * @throws YLYunException
     */
    public function recommendUgcFeed($load_type, $uid = '0') {
    	$input = [
    		'load_type' => $load_type,
    		'uid' => $uid,
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

    /**
     * 个性化推荐携带广告
     * @param FeedWithAdParam $adFeedParam
     * @return array  数据数组，视频或者广告数据对象
     * @throws YLYunException
     */
    public function feedWithAd(FeedWithAdParam $adFeedParam) {
        $this->params = array_merge($this->common, $adFeedParam->toArray());
        $url = Tools::getFullUrl(self::$urls['feed_with_ad'], $this->params);
        $res = Http::get($this->client, $url);
        if ($res['code'] == '200' && $res['data']) {
            return $res['data'];
        } else {
            throw new YLYunException($res['msg'], $res['code']);
        }
    }
}