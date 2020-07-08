<?php


namespace Faed\Pay\PayChannel;

/**
 * Interface PayChannel 支付的实现
 * @package Faed\Pay\PayChannel
 */
interface PayChannel
{
    /**
     * 接授配置
     * PayChannel constructor.
     * @param $config
     */
    public function __construct($config);

    /**
     * 统一下单入口
     * @param array $parameter 支付参数
     * @return mixed
     */
    public function unifiedOrder($parameter);

    /**
     * 处理回调
     * @param $parameter
     * @return mixed
     */
    public function parsePayNotify($parameter);

    /**
     * 订单查询
     * @param $parameter
     * @return mixed
     */
    public function orderQuery($parameter);


    /**
     * 订单关闭
     * @param $parameter
     * @return mixed
     */
    public function closeOrder($parameter);

    /**
     * 退款
     * @param $parameter
     * @return mixed
     */
    public function refund($parameter);

    /**
     * 退款查询
     * @param $parameter
     * @return mixed
     */
    public function refundQuery($parameter);

    /**
     * 处理请求
     * @param $url
     * @param $parameter
     * @return mixed
     */
    public function request($url,$parameter);

    /**
     * 添加参数
     * @param $parameter
     * @return mixed
     */
    public function addPayData($parameter);
}
