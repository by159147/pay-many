<?php


namespace Faed\Pay\PayChannel;


use Faed\Pay\Hooks\Decorator;

abstract class PayChannelAbstract
{
    /**
     * @var Decorator 装饰器
     */
    public $decorator = [];


    /**
     * 添加装饰器
     * @param Decorator $decorator
     */
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
