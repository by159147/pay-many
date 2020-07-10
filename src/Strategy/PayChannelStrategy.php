<?php


namespace Faed\Pay\Strategy;
use Faed\Pay\Hooks\JlPayXcxCloseHook;
use Faed\Pay\Hooks\JlPayXcxHook;
use Faed\Pay\Hooks\JlPayXcxNoticeHook;
use Faed\Pay\Hooks\JlPayXcxQueryHook;
use Faed\Pay\Hooks\JlPayXcxRefundHook;
use Faed\Pay\PayChannel\PayChannel;
use Faed\Pay\PayChannel\PayChannelFactory;
use Exception;
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
     * Pay constructor.
     * @param $payname
     * @throws \Exception
     */
    public function __construct($payname)
    {
        $this->passageway = PayChannelFactory::getInterface($payname,config("pay.passageway.{$payname}"));
    }

    /**
     * @param $parameter 支付参数
     * @param array $decorator
     * @return mixed
     */
    public function unifiedOrder($parameter,$decorator = [])
    {
        $this->passageway->addDecorator(new JlPayXcxHook());

        foreach ($decorator as $value){
            $this->passageway->addDecorator(new $value);
        }

        return $this->passageway->unifiedOrder((array)$parameter);
    }

    /**
     * 回调
     * @param $parameter
     * @param array $decorator
     * @return mixed
     */
    public function parsePayNotify($parameter,$decorator = [])
    {
        $this->passageway->addDecorator(new JlPayXcxNoticeHook());

        foreach ($decorator as $value){
            $this->passageway->addDecorator(new $value);
        }

        return $this->passageway->parsePayNotify($parameter);
    }


    /**
     * 查询
     * @param $parameter
     * @param array $decorator
     * @return mixed
     */
    public function orderQuery($parameter,$decorator = [])
    {
        $this->passageway->addDecorator(new JlPayXcxQueryHook());

        foreach ($decorator as $value){
            $this->passageway->addDecorator(new $value);
        }

        return $this->passageway->orderQuery($parameter);
    }

    /**
     * 退款
     * @param $parameter
     * @param array $decorator
     * @return mixed
     */
    public function refund($parameter,$decorator = [])
    {
        $this->passageway->addDecorator(new JlPayXcxRefundHook());

        foreach ($decorator as $value){
            $this->passageway->addDecorator(new $value);
        }

        return $this->passageway->refund($parameter);
    }

    /**
     * 关闭订单
     * @param $parameter
     * @param array $decorator
     * @return mixed
     */
    public function closeOrder($parameter,$decorator = [])
    {
        $this->passageway->addDecorator(new JlPayXcxCloseHook());

        foreach ($decorator as $value){
            $this->passageway->addDecorator(new $value);
        }

        return $this->passageway->closeOrder($parameter);
    }

    /**
     * @param $parameter
     * @return mixed
     * @throws Exception
     */
    public function authbind($parameter)
    {
        if (!method_exists($this->passageway,'authbind')){
            throw new Exception('该方法不存在');
        }
        return $this->passageway->authbind($parameter);
    }
}
