<?php


namespace Faed\Pay\Sdk\JLSDK;

use Faed\Pay\Sdk\JLSDK\RSA;

/**
 * 签名
 * @package Faed\Pay\Sdk\JLSDK
 */
class SignUtils
{


    /**
     * @param $params
     * @param $merPriKey
     * @throws \Exception
     */
    public static function rsaSign($params,$merPriKey)
    {
        $dataStr = self::getJsonStr($params);

        return RSA::rsaSign($dataStr, $merPriKey);
    }



    /**
     * @param $params
     * @return string
     * @throws \Exception
     */
    public static function getJsonStr($params) {
        if (!is_array($params)) {
            return $params;
        }

        if (count($params) <= 0) {
            throw new \Exception("检查参数");
        }

        ksort($params);
        return json_encode($params,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
}
