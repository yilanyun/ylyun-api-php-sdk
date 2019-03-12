<?php
/**
 * 服务测试模块
 * 用法：php client_example.php $mod_name
 * mod_name 值阈[channel, recommend, search, video]
 */

require __DIR__ . '/../autoload.php';
use YLYun\Client;
use YLYun\Params\FeedWithAdParam;

class TestSdk {

	private $client;

	public function __construct() {
		//测试共用参数
		$comm = [
			'udid' => '5459daf640bdb6a6a7e294a5f3f5f0d1',
			'ver' => '1.5.3.224',
			'model' => 'COL-AL10',
			'ip' => '1.202.240.202',
		];
		$this->client = new Client($comm);
	}

	//测试渠道服务
	public function testChannel() {
		echo "\n ###获取频道数据### \n";
		$chan = $this->client->channel()->getChannel();
		var_export($chan);
	}

	//测试推荐服务
	public function testRecommend() {
		$uid = 1024024;
		$type = 0;
		$channel_id = 1351;

		echo "\n ###获取短视频推荐数据### \n";
		$data = $this->client->recommend()->recommendFeed($type, $channel_id, $uid);
		var_export($data);

		echo "\n ###获取小视频推荐数据### \n";
		$data = $this->client->recommend()->recommendUgcFeed($type, $uid);
		var_export($data);

        echo "\n ###获取个性化推荐视频(携带广告)数据### \n";
        $adFeedParam = new FeedWithAdParam();
        $adFeedParam->format([
            'channel_id' => '1351',
            'adid' => 'TEST_YILAN',
            'os' => 1,
            'os_ver' => '12.1',
            'pkg_name' => '',
            'network' => 1,
            'ua' => 'test',
            'carrier' => 70120
        ]);
        $data = $this->client->recommend()->feedWithAd($adFeedParam);
		var_export($data);
	}

	//测试搜索服务
	public function testSearch() {
		$keyword = "好兔视频";

		echo "###短视频搜索### \n";
		$data = $this->client->search()->searchVideo($keyword);
		var_export($data);
	}

	//测试视频服务
	public function testVideo() {
		$vid = 'lm5lG1kXxjp2';

		echo "\n ###获取视频详情数据### \n";
		$detail = $this->client->video()->videoDetail($vid);
		var_export($detail);

		echo "\n ###获取视频相关数据### \n";
		$relate = $this->client->video()->videoRelate($vid);
		var_export($relate);

		echo "\n ###获取视频播放数据### \n";
		$play = $this->client->video()->videoPlay($vid);
		var_export($play);
	}

	public function run($mod) {
		$method = "test{$mod}";
		$this->{$method}();
	}
}

//开始测试
if ($argv[1]) {
	$modArr = ['channel','recommend','search', 'video'];
	$mod = $argv[1];
	if (in_array($mod, $modArr)) {
		$obj = new TestSdk();
		$obj->run($mod);
	} else {
		echo "input module error, must in [channel,recommend, search, video]\n";
	}
} else {
	echo "pls input test module [channel,recommend, search, video]\n";
}
echo "\ntest done!\n";

?>