<?php


namespace Faed\Pay\Hooks;


use Faed\Pay\Models\PayRequest;
use Illuminate\Support\Facades\Log;

class JlPayXcxQueryHook implements Decorator
{

    public function before($parameter)
    {
        Log::alert('嘉联-小程序支付-查询订单前',$parameter);
    }

    public function after($response)
    {
        Log::alert('嘉联-小程序支付-查询订单后',$response);
        PayRequest::where('order_number',$response['out_trade_no'])->where('status','<>',$response['status'])->update(['status'=>$response['status']]);
    }
}
