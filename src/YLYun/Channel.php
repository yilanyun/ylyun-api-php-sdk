<?php
/**
 * 一览视频云 频道
 */

namespace YLYun;

use YLYun\Exceptions\YLYunException;

class Channel
{

    /**
     * @var Client
     */
    private $client;
    public $common;
    public $params;
    public $urls = [
        'channel' => '/openv2/video/getchannel',
    ];

    public function __construct($client)
    {
        $this->client = $client;
        $this->common = $this->client->getCommParams();
    }

    /**
     * @return mixed
     * @throws YLYunException
     */
    public function getChannel()
    {
        $this->params = $this->common;
        $res = Tools::api($this->urls['channel'], $this->client, $this->params);
        if ($res['retcode'] == '200' && $res['data']) {
            return $res['data'];
        } else {
            throw new YLYunException($res['retmsg'], $res['retcode']);
        }
    }
}