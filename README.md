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
access_token通常用作计算请求加密和签名的密钥，用以保证该请求是来自指定的客户。
使用access_key进行身份识别，加上access_token进行加密与签名，即可完成应用接入与认证授权。

找到 src/YLYun/config.php 配置文件，完善配置信息。
```php
<?php

namespace YLYun;

class Config {

    //以下常量上线前需要修改 请咨询一览接口人索取
    const ACCESS_KEY = '';
    const ACCESS_TOKEN = '';
    const ENV = 'dev';  //环境 dev/prod

    //以下常量不需要修改
    const HOST_PROD = 'https://videoapiv2.yladm.com'; //线上正式域名
    const HOST_DEV = 'http://testapi.yladm.com';
    const USER_AGENT = 'YLYun-PHP-Client';
    const CONNECT_TIMEOUT = 5;
    const READ_TIMEOUT = 10;
    const DEFAULT_MAX_RETRY_TIMES = 2;
    const DEFAULT_LOG_FILE = "./ylyun.log";
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_OK = '200';
}
```


#### 初始化

```php
use YLYun\Client as Client;
...
...

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

...
```
#### 参数说明

| 参数名称 | 类型 | 是否可为空 | 是否必传 | 解释 |
| :--- | :--- | :--- | :--- | :--- |
| udid | string | 否 | 是  | 设备唯一标识 |
| sver | string | 否 | 是 | 接口api版本号，用于接口升级 （请填写 "2019-05-01") |
| prid | int | 否 | 是 | 区分请求接口来源（请填写 9） |
| ip | string | 是 | 是 | 客户端真实ip地址 |
| ver | string | 是 | 是 | 客户端版本 |
| mac | string | 是 | 是 | 设备mac地址 |
| imei | string | 是 | 是 | 设备imei，限于Android |
| imeimd5 | string | 是 | 是 | 设备imeimd5  |
| idfa | string | 是 | 是 | 设备idfa，限于iOS |
| model | string | 是 | 是 | 客户端设备型号  如 Nexus 4 |
| brand | string | 是 | 是 | 设备厂商 如[小米(xiaomi) &#124;华为(hauwei)&#124;魅族(meizu)] |
| adid | string | 是 | 是 | Android ID，字母大写  |
| nt | string  | 是 | 是 | 网络环境 1-WIFI，2-5G以上，3-2G，4-3G，5-4G，0-未知 |
| telecom | string | 是 | 是 | 运营商 70120-移动，70121-电信，70123-联通，0—其他 |
| os_ver | string | 是 | 是 | 客户端操作系统版本 |
| pkg_name| string |是 | 是| 应用包名(长度5 到 64位) |

#### 渠道相关服务

```php
$chan = $this->client->channel()->getChannel();
```

#### 推荐相关服务

```php
$load_type  = 0;
$channel_id = 1291;

// 获取短视频推荐数据
$data = $this->client->recommend()->feed($load_type, $channel_id);

// 获取小视频推荐数据
$data = $this->client->recommend()->ugcFeed($load_type);

```

#### 搜索相关服务

```php
$this->client->search()->searchVideo($keyword);
```
#### 参数说明

| 参数名称 | 类型 | 默认值 | 是否必传 | 解释 |
| --- | --- | --- | --- | --- |
| keyword | string | 无 | 是 | 搜索关键字 |

#### 视频相关服务

```php
$vid = 'lm5lG1kXxjp2';

// 获取视频详情数据
$detail = $this->client->video()->detail($vid);

// 获取视频播放地址
$detail = $this->client->video()->play($vid);

// 获取视频相关数据
$relate = $this->client->video()->relation($vid);

// 获取短视频详情推荐数据
$data = $this->client->video()->detailFeed($vid);

```
#### 参数说明

| 参数名称 | 类型 | 默认值 | 是否必传 | 解释 |
| --- | --- | --- | --- | --- |
| vid | string | 无 | 是 | 视频唯一标识ID |


## Examples


测试样例文件 examples/client_example.php

**简单使用方法**

若要运行 client_example.php 中的示例代码：

``` bash
# 假定当前目录为 YLYun 源码所在的根目录
$ php examples/client_example.php channel
$ php examples/client_example.php recommend
$ php examples/client_example.php video
```
> 同时也可编辑相关的示例文件，更改参数查看执行效果



### 所有异常

* YLYun\Exceptions\APIConnectionException ，表示http请求的相关异常。
* YLYun\Exceptions\YLYunException ，其他异常。

## License

MIT