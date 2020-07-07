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
            $table->string('target_order_id')->nullable()->comment('第三方订单号');
            $table->string('goods_name')->comment('商品名称');
            $table->string('order_desc')->nullable()->comment('账单描述');
            $table->integer('total_amount',false,true)->comment('支付总金额 单位:分');
            $table->integer('refund_total_amount',false,true)->default(0)->comment('退款金额 单位:分');
            $table->string('notify_url')->comment('支付结果通知地址');
            $table->string('return_url')->nullable()->comment('网页跳转地址');
            $table->string('show_url')->nullable()->comment('订单展示页面');
            $table->string('is_notice')->default(1)->comment('是否通知 1未通知 2已通知');
            $table->string('user')->comment('用户标识');
            $table->tinyInteger('status')->default(0)->comment('状态 0订单创建成功 1待确认（下单成待支付） 2支付成功 3失败 4已撤销 5已退款');
            $table->unique('order_number');
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
