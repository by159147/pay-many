<?php


namespace Faed\Pay\Hooks;


use Faed\Pay\Models\PayInfoNotice;
use Faed\Pay\Models\PayNotice;

class JlPayXcxNoticeHook
{
    public static function handle($parameter)
    {
        $pay = PayNotice::create([
            'pay_time'=>$parameter['trans_time'],
            'user'=>$parameter['sub_openid'],
            'target_order_id'=>$parameter['transaction_id'],
            'order_number'=>$parameter['out_trade_no'],
            'buyer_pay_amount'=>$parameter['total_fee'],
        ]);
        $pay->paySubNotice()->saveMany([new PayInfoNotice(['content'=>$parameter])]);

    }
}
