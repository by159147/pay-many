<?php


namespace Faed\Pay\Adapter;


class JlPayXcxChannelAdapter
{
    /**
     * @param $response
     * @return array
     * @throws \Exception
     */
    public function pay($response)
    {
        //调取失败
        if ($response['ret_code'] !== '00'){
            throw new \Exception("{$response['ret_msg']}");
        }
        // 格式化相关数据
        return ['payInfo'=>json_decode($response['pay_info'],true),'orderId'=>$response['out_trade_no']];
    }

    public function refund()
    {

    }


    public function close()
    {

    }


    public function query()
    {

    }
}
