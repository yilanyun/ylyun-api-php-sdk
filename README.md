# 一览视频云 PHP SDK

## 运行环境
- PHP 5.3+
- composer


## 安装

#### 使用 Composer 安装

- 在项目中的 `composer.json` 文件中添加 ylyun 依赖：

```json
"require": {
    "ylyun/ylyun": "*"
}
```

- 执行 `$ php composer.phar install` 或 `$ composer install` 进行安装。


## 使用说明

#### 申请ACCESS_KEY、ACCESS_TOKEN等参数信息
使用鉴权服务，需要一览颁发的access_key（长度为12个字符的ASCII字符串）和 access_token（长度为256个字符的ASCII字符串），目前可通过售前人员获取。
access_key用于标识客户的身份，access_token作为私钥形式存放于客户服务器不在网络中传递。
access_token通常用作计算请求签名的密钥，用以保证该请求是来自指定的客户。
使用access_key进行身份识别，加上access_token进行数字签名，即可完成应用接入与认证授权。

找到 src/YLYun/config.php 配置文件，完善配置信息。
```php
<?php

namespace YLYun;

class Config {

    //以下常量上线前需要修改 请咨询一览接口人索取
    const ACCESS_KEY    = '';
    const ACCESS_TOKEN  = '';
    const PLATFORM      = ''; //渠道名称
    const ENV           = 'prod';  //环境 dev/prod
    const HOST_PROD     = 'https://openapiv2.yilan.tv'; //线上正式域名

    //以下常量不需要修改
    const HOST_DEV      = 'https://testapi.yilan.tv';
    const FORMAT        = 'json';
    const USER_AGENT    = 'YLYun-PHP-Client';
    const CONNECT_TIMEOUT = 5;
    const READ_TIMEOUT = 10;
    const DEFAULT_MAX_RETRY_TIMES = 2;
    const DEFAULT_LOG_FILE = "./ylyun.log";
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_OK   = '200';
}
```


#### 初始化

```php
use YLYun\Client as Client;
...
...

    //测试共用参数
    $comm = [
        'udid' => '5459daf640bdb6a6a7e294a5f3f5f0d1',
        'ver' => '1.5.3.224',
        'model' => 'COL-AL10',
        'ip' => '1.202.240.202',
    ];
    $this->client = new Client($comm);

...
```

#### 渠道相关服务

```php
$this->client->channel()->getChannel();
```

#### 推荐相关服务

```php
//获取短视频推荐数据
$data = $this->client->recommend()->recommendFeed($type, $channel_id, $uid);
//获取小视频推荐数据
$data = $this->client->recommend()->recommendUgcFeed($type, $uid);
//获取个性化推荐视频(携带广告)数据
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
```

#### 搜索相关服务

```php
$this->client->search()->searchVideo($keyword);
```

#### 视频相关服务

```php
//获取视频详情数据
$detail = $this->client->video()->videoDetail($vid);

//获取视频相关数据
$relate = $this->client->video()->videoRelate($vid);


//获取视频播放数据
$play = $this->client->video()->videoPlay($vid);
```

#### 入参说明

| 参数名称 | 类型 | 默认值 | 是否必传 | 解释 |
| :---: | :---: | :---: | :---: | :---: |
| platform | string | 无 | 是 | 平台标识 如 [Android | iPhone]   |
| udid | string | 无 | 是 | 设备唯一标识 |
| ip | string | 无 | 否 | 客户端真实ip地址 |
| ver | string | 无 | 否 | 客户端版本 |
| uid | string | 无 | 否 | 用户账号 |
| model | string | 无 | 否 | 客户端设备型号  如 Nexus 4 |
| brand | string | 无 | 否 | 设备厂商 如:小米(xiaomi)、华为(hauwei)、魅族(meizu) |
| auth_key | string | 无 | 否 | CDN签名 （非客户端SDK,忽略该字段） |
|  |  |  |  |  |
| channel_id | int | 无 | 是 | 频道 ID，由频道列表接口获得该值 |
| adid | string | 空 | 是 | Android ID，字母大写 |
| os | int | 0 | 是 | 操作系统类型，1-iOS,2- Android,0-其他 |
| os_ver | string | 空 | 是 | 操作系统版本，点分十进制 |
| pkg_name | string | 空 | 是 | 应用包名 |
| network | int | 0 | 是 | 网络环境，1-WIFI,2-5G 以上,3- 2G,4-3G,5-4G,0-未知 |
| ua | string | 空 | 是 | 客户端 User Agent |
| carrier | int | 0 | 是 | 运营商 70120-移动,70121-电 信,70123-联通,0-其他 |




## Examples


测试样例文件 examples/client_example.php

**简单使用方法**

若要运行 client_example.php 中的示例代码：

``` bash
# 假定当前目录为 YLYun 源码所在的根目录
$ php examples/client_example.php channel
$ php examples/client_example.php recommend
$ php examples/client_example.php search
$ php examples/client_example.php video
```
> 同时也可编辑相关的示例文件，更改参数查看执行效果



### 所有异常

* YLYun\Exceptions\APIConnectionException ，表示http请求的相关异常。
* YLYun\Exceptions\YLYunException ，其他异常。

## License

MIT