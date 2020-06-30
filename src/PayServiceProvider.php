<?php


namespace Faed\Pay;

use Illuminate\Support\ServiceProvider;
class PayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //数据迁移
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        //配置文件
        $this->publishes([
            $this->configPath() => config_path('pay.php'),
        ]);


    }

    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'pay');
    }

    /**
     * Set the config path
     *
     * @return string
     */
    protected function configPath()
    {
        return __DIR__ . '/config/pay.php';
    }
}
