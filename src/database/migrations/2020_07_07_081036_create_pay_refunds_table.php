<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_refunds', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->comment('退款订单号');
            $table->string('target_order_id')->nullable()->comment('退款订单号 第三方');
            $table->string('ori_order_number')->nullable()->comment('原始订单号');
            $table->string('ori_target_order_id')->comment('原平台订单号');
            $table->integer('total_amount')->comment('退款金额');
            $table->string('user')->nullable()->comment('退款发起人');
            $table->string('platform_refund')->nullable()->comment('退款发起平台');
            $table->text('content_response')->nullable()->comment('退款响应');
            $table->text('content_request')->nullable()->comment('退款请求');
            $table->tinyInteger('status')->default(1)->comment('状态 1待退款 2已退款');
            $table->unique('order_number');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `pay_refunds` comment '退款表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_refunds');
    }
}
