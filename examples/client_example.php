<?php
require __DIR__ . '/../autoload.php';

use YLYun\Client as Client;
//测试共用参数
$comm = [
	'udid' => '5459daf640bdb6a6a7e294a5f3f5f0d1',
	'ver' => '1.5.3.224',
	'model' => 'COL-AL10',
	'ip' => '1.202.240.202',
];

$client = new Client($comm);
//频道服务
$chan = $client->channel()->getChannel();
var_dump($chan);

//推荐服务
$uid = 1024024;
$type = 0;
$channel_id = 1351;
$log_id = uniqid();
$data = $client->recommend()->recommendVideo($uid, $type, $channel_id, $log_id);
var_dump($data);

//视频服务
$vid = 'lm5lG1kXxjp2';
$detail = $client->video()->videoDetail($vid);
var_dump($detail);

$relate = $client->video()->videoRelate($vid);
var_dump($relate);

$play = $client->video()->microVideoPlay($vid);
var_dump($play);
