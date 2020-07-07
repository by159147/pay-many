<?php


namespace Faed\Pay\PayChannel;


class PayChannelFactory
{
    /**
     * @param $payname
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public static function getInterface($payname,$config = [])
    {
        $payClassname = "Faed\\Pay\\PayChannel\\Imps\\{$payname}";

        if (!class_exists($payClassname)){
            throw new \Exception("[$payname]支付通道不存在");
        }
        return (new $payClassname($config));
    }
}
