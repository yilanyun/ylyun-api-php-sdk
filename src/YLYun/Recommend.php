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
		'video' => [
			'uri' => '/video/feed',
			'keys' => ['uid','load_type','channel_id','log_id'],
		],
		'video_ad' => [

		],
		'micro_video' => [

		],
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
    public function recommendVideo($uid, $load_type, $channel_id, $log_id) {
    	$input = array_combine(self::$urls['video']['keys'], func_get_args());
    	$this->params = array_merge($this->common, $input);
    	$url = Tools::getFullUrl(self::$urls['video'], $this->params);
    	$res = HTTP::get($this->client, $url);
    	if ($res['code'] == '200' && $res['data']) {
    		return $res['data'];
    	} else {
    		throw new YLYunException($res['msg'], $res['code']);
    	}
    }

	//携带广告的频道推荐
    public function recommendWithAd() {

    }

    //小视频推荐列表
    public function recommendMicroVideo() {

    }
}