<?php
/**
 * 服务测试模块
 * 用法：php client_example.php $mod_name
 * mod_name 值阈[channel, recommend, video]
 */

require __DIR__ . '/../autoload.php';

use YLYun\Client;

class TestSdk
{
    private $common_params;
    private $client;

    public function __construct()
    {
        //共用参数
        $this->common_params = [
            'udid'     => '5459daf640bdb6a6a7e294a5f3f5f0d1', // 设备唯一标识，客户端生成
            'sver'     => '2019-05-01', // 服务端版本
            'prid'     => '9',  // 区分请求接口来源（api 默认填 9）
            'ip'       => '1.202.240.202',  // 客户端ip地址
            'ver'      => '1.5.3.224', // 客户端版本
            'mac'      => '', // 设备mac地址，限于Android
            'imei'     => '', // 设备imei，限于Android
            'imeimd5'  => '', // 设备imei脱敏信息，imei采用md5方式处理
            'idfa'     => '', // 设备idfa，限于iOS
            'model'    => '', // 设备型号
            'brand'    => '', // 设备厂商
            'adid'     => '', // Android ID，字母大写
            'nt'       => '', // 客户端网络环境
            'telecom'  => '', // 客户端运营商
            'os_ver'   => '', // 客户端操作系统版本
            'pkg_name' => '', // 应用包名
        ];
        $this->client = new Client($this->common_params);
    }

    /**
     * 测试渠道服务
     * @throws YLYun\Exceptions\YLYunException
     */
    public function testChannel()
    {
        echo "\n ###获取频道数据### \n";
        $chan = $this->client->channel()->getChannel();
        var_export($chan);
    }

    /**
     * 测试推荐服务
     * @throws YLYun\Exceptions\YLYunException
     */
    public function testRecommend()
    {
        $load_type  = 0;
        $channel_id = 1291;

        echo "\n ###获取短视频推荐数据### \n";
        $data = $this->client->recommend()->feed($load_type, $channel_id);
        var_export($data);

        echo "\n ###获取小视频推荐数据### \n";
        $data = $this->client->recommend()->ugcFeed($load_type);
        var_export($data);
    }

    /**
     * 测试视频服务
     * @throws YLYun\Exceptions\YLYunException
     */
    public function testVideo()
    {
        $vid = 'lm5lG1kXxjp2';

        echo "\n ###获取视频详情数据### \n";
        $detail = $this->client->video()->detail($vid);
        var_export($detail);

        echo "\n ###获取视频播放地址### \n";
        $detail = $this->client->video()->play($vid);
        var_export($detail);

        echo "\n ###获取视频相关数据### \n";
        $relate = $this->client->video()->relation($vid);
        var_export($relate);

        echo "\n ###获取短视频详情推荐数据### \n";
        $data = $this->client->video()->detailFeed($vid);
        var_export($data);

    }

    public function run($mod)
    {
        $method = "test{$mod}";
        $this->{$method}();
    }
}

// 开始测试
if ($argv[1]) {
    $modArr = ['channel', 'recommend', 'video'];
    $mod    = $argv[1];
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