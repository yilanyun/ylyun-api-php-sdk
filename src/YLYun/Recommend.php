<?php
/**
 * 一览云内容推荐
 */

namespace YLYun;

use YLYun\Exceptions\YLYunException;
use YLYun\Params\FeedWithAdParam;

class Recommend
{
    /**
     * @var \YLYun\Client
     */
    private $client;
    public $common;
    public $params;

    public $urls = [
        'feed'     => '/openv2/video/feed',
        'ugc_feed' => '/openv2/video/ugcfeed',
    ];

    public function __construct($client)
    {
        $this->client = $client;
        $this->common = $this->client->getCommParams();
    }

    /**
     * 频道推荐列表
     * @param  int $load_type 0-上拉加载更多 1-非首次下拉刷新时 2-首次刷新某个频道
     * @param  string $channel_id 频道id
     * @return array  推荐数据
     * @throws YLYunException
     */
    public function feed($load_type, $channel_id)
    {
        $input        = [
            'load_type'  => $load_type,
            'channel_id' => $channel_id,
        ];
        $this->params = array_merge($this->common, $input);
        $res = Tools::api($this->urls['feed'], $this->client, $this->params);
        if ($res['retcode'] == '200' && $res['data']) {
            return $res['data'];
        } else {
            throw new YLYunException($res['retmsg'], $res['retcode']);
        }
    }

    /**
     * 小视频推荐列表
     * @param  int $load_type 0-上拉加载更多 1-非首次下拉刷新时 2-首次刷新某个频道
     * @return array  推荐数据
     * @throws YLYunException
     */
    public function ugcFeed($load_type)
    {
        $input        = [
            'load_type' => $load_type,
        ];
        $this->params = array_merge($this->common, $input);
        $res = Tools::api($this->urls['ugc_feed'], $this->client, $this->params);
        if ($res['retcode'] == '200' && $res['data']) {
            return $res['data'];
        } else {
            throw new YLYunException($res['retmsg'], $res['retcode']);
        }
    }
}