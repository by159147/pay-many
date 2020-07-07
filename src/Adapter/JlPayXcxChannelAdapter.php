<?php


namespace Faed\Pay\Adapter;

class JlPayXcxChannelAdapter
{

    /**
     * @param $response
     * @return array
     * @throws \Exception
     */
    public static function pay($response)
    {
        self::verificationHttp($response);
        self::verificationStatus($response);
        // 格式化相关数据
        return ['payInfo'=>json_decode($response['pay_info'],true),'orderId'=>$response['out_trade_no']];
    }

    /**
     * @param $response
     * @throws \Exception
     */
    public static function refund($response)
    {
        self::verificationHttp($response);
        self::verificationStatus($response);

        return ['target_order_id'=>$response['transaction_id'],'order_number'=>$response['out_trade_no'],'total_amount'=>$response['total_fee'],'pay_time'=>$response['trans_time']];
    }


    public static function close()
    {

    }


    /**
     * @param $response
     * @return array
     * @throws \Exception
     */
    public static function query($response)
    {
        self::verificationHttp($response);
        //1-待确认2-成功3-失败4-已撤销5-已退款
        return ['target_order_id'=>$response['transaction_id'],'order_number'=>$response['out_trade_no'],'total_amount'=>$response['total_fee'],'status'=>$response['status'],'pay_time'=>$response['trans_time']];
    }

    /**
     * @param $response
     * @throws \Exception
     */
    public static function verificationHttp($response)
    {
        //调取失败
        if ($response['ret_code'] !== '00'){
            throw new \Exception("{$response['ret_msg']} 平台订单号：");
        }
    }


    /**
     * 验证业务是否成功
     * @param $response
     * @throws \Exception
     */
    public static function verificationStatus($response)
    {
        if ($response['status'] == 3){
            throw new \Exception("{$response['ret_msg']}");
        }
    }
}
