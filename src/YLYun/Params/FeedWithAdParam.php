<?php
/**
 * 个性化推荐携带广告入参类
 */

namespace YLYun\Params;


class FeedWithAdParam extends Base
{
    /**
     * @var int 频道 ID，由频道列表接口获得该值
     */
    public $channel_id;

    /**
     * @var string Android ID，字母大写
     */
    public $adid = '';

    /**
     * @var int 操作系统类型，1-iOS,2- Android,0-其他
     */
    public $os = 0;

    /**
     * @var string 操作系统版本，点分十进制
     */
    public $os_ver = '';

    /**
     * @var string 应用包名
     */
    public $pkg_name = '';

    /**
     * @var int 网络环境，1-WIFI,2-5G 以上,3- 2G,4-3G,5-4G,0-未知
     */
    public $network = 0;

    /**
     * @var string 客户端 User Agent
     */
    public $ua = '';

    /**
     * @var int 运营商 70120-移动,70121-电 信,70123-联通,0-其他
     */
    public $carrier = 0;
}