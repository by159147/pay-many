<?php


namespace Faed\Pay\Strategy;
use Faed\Pay\PayChannel\PayChannel;
use Faed\Pay\PayChannel\PayChannelFactory;

/**
 * 策略
 * @package Faed\Pay\Strategy
 */
class PayChannelStrategy
{
    /**
     * 支付通道
     * @var PayChannel string
     */
    public $passageway;

    /**
     * 支付配置
     * @var
     */
    public $payConfig;

    /**
     * Pay constructor.
     * @param $payname
     * @throws \Exception
     */
    public function __construct($payname)
    {
        $this->passageway = PayChannelFactory::getInterface($payname);

        $this->payConfig = config("pay.passageway.{$payname}");
    }

    public function unifiedOrder($parameter)
    {
        return $this->passageway->unifiedOrder($this->payConfig,$parameter);
    }
}
