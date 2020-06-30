<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pay_tag')->comment('支付标志');
            $table->string('pay_platform')->comment('支付平台');
            $table->string('pay_type')->comment('支付类型');
            $table->string('app_name')->comment('应用名称');
            $table->string('order_number')->comment('订单号');
            $table->string('goods_name')->comment('商品名称');
            $table->string('order_desc')->nullable()->comment('账单描述');
            $table->integer('total_amount',false,true)->comment('支付总金额 单位:分');
            $table->string('notify_url')->comment('支付结果通知地址');
            $table->string('return_url')->nullable()->comment('网页跳转地址');
            $table->string('show_url')->nullable()->comment('订单展示页面');
            $table->string('user')->comment('用户标识');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_requests');
    }
}
