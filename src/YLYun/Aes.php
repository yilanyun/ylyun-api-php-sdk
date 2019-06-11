<?php

namespace YLYun;

/**
 * Class Util_Encrypt_AES
 */
class AES
{
    const AES_ECB = 'ECB';
    const AES_CBC = 'CBC';

    /**
     * 功能：
     * @param $input
     * @param $key
     * @param $mode
     * @param $iv
     * @return string
     */
    public static function openssl_encrypt($input, $key, $mode, $iv = "")
    {
        $data = openssl_encrypt($input, $mode, $key, OPENSSL_RAW_DATA, $iv);
        $data = base64_encode($data);

        return $data;
    }

    /**
     * 加密
     * @param $key
     * @param $input
     * @param string $modeType
     * @return string
     */
    public static function encrypt($key, $input, $modeType = self::AES_CBC)
    {
        $mode = self::getMode(strlen($key), $modeType);
        $iv   = self::getIv($key);
        if ($mode) {
            return self::openssl_encrypt($input, $key, $mode, $iv);
        }
        return '';
    }

    /**
     * @param $text
     * @param $blockSize
     * @return string
     */
    public static function PKCS5Padding($text, $blockSize)
    {
        $pad = $blockSize - (strlen($text) % $blockSize);

        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * 解密
     * @param $key
     * @param $sStr
     * @param string $modeType
     * @return string
     */
    public static function decrypt($key, $sStr, $modeType = self::AES_CBC)
    {
        $mode = self::getMode(strlen($key), $modeType);
        $iv   = self::getIv($key);
        if ($mode) {
            $decrypted =
                openssl_decrypt(base64_decode($sStr), $mode, $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
        } else {
            $decrypted = '';
        }

        // $decrypted = mb_convert_encoding($decrypted, 'UTF-8', 'ASCII,GB2312,GBK,UTF-8,BIG5');
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s - 1]);
        if ($padding > 0 && $padding <= 16) {
            $decrypted = substr($decrypted, 0, -$padding);
        }

        return rtrim($decrypted);
    }

    /**
     * 功能：获取加解密的Mode，KEY的长度不同会影响到OpenSSL中aes-x-cbc是选择128，192还是256。
     * @param $lenKey
     * @param $modeType
     * @return string
     */
    private static function getMode($lenKey, $modeType)
    {
        $mode = '';
        if ($modeType == self::AES_ECB) {
            if ($lenKey == 16) {
                $mode = 'AES-128-ECB';
            } else {
                if ($lenKey == 24) {
                    $mode = 'AES-192-ECB';
                } else {
                    if ($lenKey == 32) {
                        $mode = 'AES-256-ECB';
                    }
                }
            }
        } else {
            if ($lenKey == 16) {
                $mode = 'AES-128-CBC';
            } else {
                if ($lenKey == 24) {
                    $mode = 'AES-192-CBC';
                } else {
                    if ($lenKey == 32) {
                        $mode = 'AES-256-CBC';
                    }
                }
            }
        }
        return $mode;
    }

    /**
     * 功能：获取初始化向量 默认截取秘钥前16位
     * @param $key
     * @return string
     */
    private static function getIv($key)
    {
        return substr($key, 0, 16);
    }
}