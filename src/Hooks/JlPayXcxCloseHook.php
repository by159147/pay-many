<?php


namespace Faed\Pay\Hooks;


use Faed\Pay\Models\PayClose;


class JlPayXcxCloseHook implements Decorator
{

    public function before($parameter)
    {
        PayClose::create([
            'order_number'=>$parameter['out_trade_no'],
            'ori_order_number'=>$parameter['ori_out_trade_no'],
            'ori_target_order_id'=>$parameter['ori_transaction_id'],
            'user'=>$parameter['user'],
            'platform_close'=> @$parameter['platform_close'],
            'content_request'=>collect($parameter)->except('user')->toArray(),
        ]);
    }

    public function after($response)
    {
        PayClose::updateorcreate(['order_number'=>$response['out_trade_no']],['content_response'=>$response,'target_order_id'=>$response['transaction_id'],'status'=>2]);
    }
}
