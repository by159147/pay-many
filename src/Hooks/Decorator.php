<?php


namespace Faed\Pay\Hooks;


interface Decorator
{
    public function before($parameter);

    public function after($response);
}
