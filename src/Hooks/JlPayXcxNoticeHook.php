<?php


namespace Faed\Pay\Hooks;


use Faed\Pay\Models\PayInfoNotice;
use Faed\Pay\Models\PayNotice;
use Illuminate\Support\Facades\Log;

class JlPayXcxNoticeHook implements Decorator
{


    /**
     * 验签前的处理
     * @param $parameter
     */
    public function before($parameter)
    {
        Log::alert('嘉联-小程序支付-回调验证签名之前',$parameter);
    }

    /**
     * 验签后处理
     * @param $parameter
     */
    public function after($parameter)
    {
        $pay = PayNotice::create([
            'pay_time'=>$parameter['trans_time'],
            'user'=>@$parameter['sub_openid'],
            'target_order_id'=>$parameter['transaction_id'],
            'order_number'=>$parameter['out_trade_no'],
            'buyer_pay_amount'=>$parameter['total_fee'],
        ]);
        $pay->paySubNotice()->saveMany([new PayInfoNotice(['content'=>$parameter])]);

    }
}
