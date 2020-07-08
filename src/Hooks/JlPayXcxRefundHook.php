<?php


namespace Faed\Pay\Hooks;


use Faed\Pay\Models\PayRefund;
use Faed\Pay\Models\PayRequest;


class JlPayXcxRefundHook implements Decorator
{

    public function before($parameter)
    {
        PayRefund::create([
            'order_number'=>$parameter['out_trade_no'],
            'ori_order_number'=>@$parameter['ori_out_trade_no'],
            'ori_target_order_id'=>$parameter['ori_transaction_id'],
            'total_amount'=>$parameter['total_fee'],
            'user'=>$parameter['user'],
            'content_request'=>collect($parameter)->except('user')->toArray(),
        ]);
    }

    public function after($response)
    {
        $payRefund = PayRefund::updateorcreate(['order_number'=>$response['out_trade_no']],['content_response'=>$response,'target_order_id'=>$response['transaction_id']]);

        //退款成功
        PayRequest::where('target_order_id',$payRefund->ori_target_order_id)->update(['status'=>5]);
        PayRequest::where('target_order_id',$payRefund->ori_target_order_id)->increment('refund_total_amount',$payRefund->total_amount);

    }
}
