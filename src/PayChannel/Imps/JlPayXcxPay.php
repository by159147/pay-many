<?php /** @noinspection ALL */


namespace Faed\Pay\PayChannel\Imps;
use Faed\Pay\Adapter\JlPayXcxChannelAdapter;
use Faed\Pay\Hooks\JlPayXcxBeforeHook;
use Faed\Pay\Hooks\JlPayXcxNoticeHook;
use Faed\Pay\Models\PayRequest;
use Faed\Pay\PayChannel\PayChannel;
use Faed\Pay\Sdk\JLSDK\SignUtils;
use GuzzleHttp\Client;
use Yansongda\Pay\Pay;

class JlPayXcxPay implements PayChannel
{

    public $merPriKey;

    /**
     * @param $payConfig
     * @param array $parameter
     * @return mixed|void
     * @throws \Exception
     */
    public function unifiedOrder($payConfig,$parameter)
    {
        //添加参数
        $parameter['org_code'] = $payConfig['org_code'];
        //未传递 商户号 读取配置商户号
        if (empty($parameter['mch_id'])){
            $parameter['mch_id'] = $payConfig['mch_id'];
        }
        $this->merPriKey = $payConfig['merPriKey'];

        //请求前的hook
        JlPayXcxBeforeHook::handle($parameter);

        //使用配置回调地址 回调地址
        $parameter['notify_url'] = $payConfig['notify_url'];
        //发起请求
        $response = $this->request('https://qrcode.jlpay.com/api/pay/officialpay',$parameter);

        $adapter = new JlPayXcxChannelAdapter();

        return $adapter->pay($response);
    }

    /**
     * @param $payConfig
     * @param $parameter
     * @return mixed|void
     * @throws \Exception
     */
    public function parsePayNotify($payConfig, $parameter)
    {
        $result = SignUtils::verify($parameter,$payConfig['jlPubKey']);
        if (!$result){
            throw new \Exception('签名验证失败');
        }
        //订单号
        if (PayRequest::where('order_number',$parameter['out_trade_no'])->where('is_notice',2)->value('id')){
            throw new \Exception('该订单已经回调');
        }

        JlPayXcxNoticeHook::handle($parameter);

        return true;
    }


    public function orderQuery()
    {
        // TODO: Implement orderQuery() method.
    }

    public function closeOrder()
    {
        // TODO: Implement closeOrder() method.
    }

    public function refund()
    {
        // TODO: Implement refund() method.
    }

    public function refundQuery()
    {
        // TODO: Implement refundQuery() method.
    }


    /**
     * @param $url
     * @param $parameter
     * @return mixed
     * @throws \Exception
     */
    public function request($url, $parameter)
    {
        //添加签名
        $parameter['sign'] = SignUtils::rsaSign($parameter,$this->merPriKey);

        $requestJsonStr = json_encode($parameter, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $client = new Client(['headers' => [ 'Content-Type' => 'application/json' ]]);
        $response = $client->post($url,
            ['body' => $requestJsonStr]
        );
        $response = json_decode($response->getBody()->getContents(),true);

        return $response;
    }

}
