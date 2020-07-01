<?php


namespace Faed\Pay\Hooks;


use Faed\Pay\Models\PayInfoRequest;
use Faed\Pay\Models\PayRequest;

/**
 * 支付请求前钩子
 * @package Faed\Pay\Hooks
 */
class JlPayXcxBeforeHook
{
    public  static function handle($parameter)
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
}
