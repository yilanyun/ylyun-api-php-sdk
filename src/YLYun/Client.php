<?php
/**
 * 一览视频云 客户端类
 * 视频类型：
 * 短视频(shortVideo)：一般时长在1分钟左右的横版视频
 * 小视频(microVideo)：一般时长在10秒左右的竖版视频
 */

namespace YLYun;

class Client {

	private $_key;
	private $_token;

	public function __construct() {
		$this->_key = Config::ACCESS_KEY;
		$this->_token = Config::ACCESS_TOKEN;
	}

	//频道模块
    public function channel() { return new Channel($this); }

	//推荐模块
    public function recommend() { return new Recommend($this); }

    //视频模块
    public function video() { return new Video($this); }

    //搜索模块
    public function search() { return new Search($this); }

    //小视频模块
    public function microvideo() { return new MicroVideo($this); }
}
