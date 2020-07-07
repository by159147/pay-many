<?php


namespace Faed\Pay\Hooks;


use Faed\Pay\Models\PayInfoRequest;
use Faed\Pay\Models\PayRequest;
use Faed\Pay\Models\PayResponse;

/**
 * 支付请求前钩子
 * @package Faed\Pay\Hooks
 */
class JlPayXcxHook implements Decorator
{
    public function before($parameter)
    {

        $pay = PayRequest::create([
            'pay_tag'=>'JlPayXcxPay',
            'pay_platform'=>'嘉联支付',
            'pay_type'=>'微信小程序',
            'app_name'=>request()->input('app_name'),
            'order_number'=>@$parameter['out_trade_no'],
            'goods_name'=>@$parameter['body'],
            'order_desc'=>@$parameter['attach'],
            'total_amount'=>@$parameter['total_fee'],
            'notify_url'=>@$parameter['notify_url'],
            'user'=>@$parameter['open_id'],
        ]);

        $pay->payInfo()->saveMany([new PayInfoRequest(['content'=>$parameter])]);

    }


    public function after($response)
    {
        PayResponse::create([
            'order_number'=>$response['out_trade_no'],
            'target_order_id'=>$response['transaction_id'],
            'content'=>$response,
        ]);

        //下单成功更新订单
        PayRequest::where('order_number',$response['out_trade_no'])->update(['status'=>1,'target_order_id'=>$response['transaction_id']]);
    }
}
