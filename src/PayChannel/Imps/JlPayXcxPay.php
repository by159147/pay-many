<?php


namespace Faed\Pay\PayChannel\Imps;

use Faed\Pay\Adapter\JlPayXcxChannelAdapter;
use Faed\Pay\Hooks\Decorator;
use Faed\Pay\Models\PayRequest;
use Faed\Pay\PayChannel\PayChannel;
use Faed\Pay\PayChannel\PayChannelAbstract;
use Faed\Pay\Sdk\JLSDK\SignUtils;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Exception;
class JlPayXcxPay extends PayChannelAbstract implements PayChannel
{
    public $config;
    /**
     * @var Decorator 装饰器
     */
    public $decorator = [];


    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param array $parameter
     * @return mixed|void
     * @throws Exception
     */
    public function unifiedOrder($parameter)
    {
        //添加参数
        $parameter = $this->addPayData($parameter,true,$parameter['app_name']);


        //请求前的hook
        $this->before($parameter);

        //使用配置回调地址 回调地址
        $parameter['notify_url'] = $this->config['notify_url'];
        //发起请求
        $response = $this->request('https://qrcode.jlpay.com/api/pay/officialpay',$parameter);

        $payData = JlPayXcxChannelAdapter::pay($response);
        //请求后的hook
        $this->after($response);

        return $payData;
    }

    /**
     * @param $parameter
     * @return mixed|void
     * @throws Exception
     */
    public function parsePayNotify($parameter)
    {
        $this->before($parameter);

        $parameter = $this->verification($parameter);

        //订单号
        if (PayRequest::where('order_number',$parameter['out_trade_no'])->where('is_notice',2)->value('id')){
            throw new Exception('该订单已经回调');
        }

        $this->after($parameter);

        return true;
    }

    /**
     * @param $parameter
     * @return array|mixed
     * @throws Exception
     */
    public function orderQuery($parameter)
    {
        //添加参数
        $parameter = $this->addPayData($parameter,false);


        $this->before($parameter);

        $response = $this->request('https://qrcode.jlpay.com/api/pay/chnquery',$parameter);
        $qurey = JlPayXcxChannelAdapter::query($response);

        $this->after($response);

        return $qurey;

    }

    /**
     * @param $parameter
     * @return array|mixed
     * @throws Exception
     */
    public function closeOrder($parameter)
    {
        //添加参数
        $parameter = $this->addPayData($parameter,false);

        $this->before($parameter);

        $response = $this->request('https://qrcode.jlpay.com/api/pay/cancel',collect($parameter)->except('user')->toArray());
        $close = JlPayXcxChannelAdapter::close($response);

        $this->after($response);

        return $close;
    }

    /**
     * @param $parameter
     * @return array|mixed
     * @throws Exception
     */
    public function refund($parameter)
    {
        //添加参数
        $parameter = $this->addPayData($parameter,false,$parameter['app_name']);

        $this->before($parameter);
        $response = $this->request('https://qrcode.jlpay.com/api/pay/refund',$parameter);
        $refund = JlPayXcxChannelAdapter::refund($response);

        $this->after($response);

        return $refund;
    }

    /**
     * 退款查询展示不支持
     * @param $parameter
     * @return mixed|void
     */
    public function refundQuery($parameter)
    {
        // TODO: Implement refundQuery() method.
    }

    /**
     * 添加参数 商户号等......
     * @param $parameter
     * @param bool $appid
     * @param string $app_name
     * @return mixed|void
     */
    public function addPayData($parameter,$appid = false,$app_name = '')
    {
        $parameter['org_code'] = $this->config['org_code'];
        //未传递 商户号 读取配置商户号
        if (empty($parameter['mch_id'])){
            $parameter['mch_id'] = $this->config['mch_id'];
        }

        if ($appid){
            $parameter['sub_appid'] = $this->config['appid'][$app_name];
        }

        return $parameter;
    }

    /**
     * @param $url
     * @param $parameter
     * @return mixed
     * @throws Exception
     */
    public function request($url, $parameter)
    {
        //添加签名
        $parameter['sign'] = SignUtils::rsaSign($parameter,$this->config['merPriKey']);

        Log::alert('嘉联-小程序-请求前参数',[
            'url' => $url,
            'oreder_number'=>@$parameter['out_trade_no'],
            'data'=>$parameter
        ]);

        $client = new Client(['headers' => [ 'Content-Type' => 'application/json' ]]);
        $response = $client->post($url,
            ['body' => json_encode($parameter, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)]
        );

        $response = json_decode($response->getBody()->getContents(),true);

        Log::alert('嘉联-小程序-请求后返回',[
            'url' => $url,
            'oreder_number'=>@$parameter['out_trade_no'],
            'data'=>$response,
        ]);

        $response =  $this->verification($response);
        return $response;
    }

    /**
     * @param $response
     * @return array
     * @throws Exception
     */
    public function verification($response)
    {
        if (!SignUtils::verify($response,$this->config['JlPubKey'])){
            throw new Exception('签名验证失败');
        }
        unset($response['sign']);
        return $response;
    }

    /**
     * @param $parameter
     * @return array
     * @throws Exception
     */
    public function authbind($parameter)
    {
        //添加参数
        $parameter = $this->addPayData($parameter,true,$parameter['app_name']);
        $response = $this->request('https://qrcode.jlpay.com/api/pay/authbind',$parameter);
        return JlPayXcxChannelAdapter::authbind($response);
    }


    public function addDecorator(Decorator $decorator)
    {
        $this->decorator[] = $decorator;
    }


    /**
     * 执行装饰器前置操作 先进先出原则
     * @param $parameter
     */
    protected function before($parameter)
    {
        foreach ($this->decorator as $decorator)
            $decorator->before($parameter);
    }

    /**
     * 执行装饰器后置操作 先进后出原则
     * @param $response
     */
    protected function after($response)
    {
        $tmp = array_reverse($this->decorator);
        foreach ($tmp as $decorator)
            $decorator->after($response);
    }
}
