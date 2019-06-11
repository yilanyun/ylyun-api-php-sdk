<?php
/**
 * 一览云视频相关
 */

namespace YLYun;

use YLYun\Exceptions\YLYunException;

class Video
{
    private $client;
    public $common;
    public $params;

    public $urls = [
        'detail'     => '/openv2/video/detail',
        'play'       => '/openv2/video/play',
        'detailFeed' => '/openv2/video/detailfeed',
        'relation'   => '/openv2/video/relation',
    ];

    public function __construct($client)
    {
        $this->client = $client;
        $this->common = $this->client->getCommParams();
    }

    /**
     * 视频详情
     * @param string $vid 视频ID
     * @return array
     * @throws YLYunException
     */
    public function detail($vid)
    {
        $input['id']  = $vid;
        $this->params = array_merge($this->common, $input);
        $res          = Tools::api($this->urls['detail'], $this->client, $this->params);
        if ($res['retcode'] == '200' && $res['data']) {
            return $res['data'];
        } else {
            throw new YLYunException($res['retmsg'], $res['retcode']);
        }
    }

    /**
     * 视频播放地址
     * @param string $vid 视频ID
     * @return array
     * @throws YLYunException
     */
    public function play($vid)
    {
        $input['id']  = $vid;
        $this->params = array_merge($this->common, $input);
        $res          = Tools::api($this->urls['play'], $this->client, $this->params);
        if ($res['retcode'] == '200' && $res['data']) {
            return $res['data'];
        } else {
            throw new YLYunException($res['retmsg'], $res['retcode']);
        }
    }

    /**
     * 获得视频详情页feed
     * @param int $pg
     * @param string $vid 视频ID
     * @return array
     * @throws YLYunException
     */
    public function detailFeed($vid, $pg = 1)
    {
        $input['id']  = $vid;
        $input['pg']  = $pg;
        $this->params = array_merge($this->common, $input);
        $res          = Tools::api($this->urls['detailFeed'], $this->client, $this->params);
        if ($res['retcode'] == '200' && $res['data']) {
            return $res['data'];
        } else {
            throw new YLYunException($res['retmsg'], $res['retcode']);
        }
    }

    /**
     * 视频相关
     * @param string $vid 视频ID
     * @return array
     * @throws YLYunException
     */
    public function relation($vid)
    {
        $input['id']  = $vid;
        $this->params = array_merge($this->common, $input);
        $res          = Tools::api($this->urls['relation'], $this->client, $this->params);
        if ($res['retcode'] == '200' && $res['data']) {
            return $res['data'];
        } else {
            throw new YLYunException($res['retmsg'], $res['retcode']);
        }
    }
}