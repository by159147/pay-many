<?php


namespace Faed\Pay\PayChannel;

/**
 * Interface PayChannel 支付的实现
 * @package Faed\Pay\PayChannel
 */
interface PayChannel
{
    /**
     * 统一下单入口
     * @param array $payConfig 配置
     * @param array $parameter 支付参数
     * @return mixed
     */
    public function unifiedOrder($payConfig,$parameter);

    /**
     * 处理回调
     * @param $payConfig
     * @param $parameter
     * @return mixed
     */
    public function parsePayNotify($payConfig,$parameter);

    /**
     * 订单查询
     * @return mixed
     */
    public function orderQuery();


    /**
     * 订单关闭
     * @return mixed
     */
    public function closeOrder();

    /**
     * 退款
     * @return mixed
     */
    public function refund();

    /**
     * 退款查询
     * @return mixed
     */
    public function refundQuery();

    /**
     * 处理请求
     * @param $url
     * @param $parameter
     * @return mixed
     */
    public function request($url,$parameter);

}
