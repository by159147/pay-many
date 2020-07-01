<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_notices', function (Blueprint $table) {
            $table->id();
            $table->dateTime('pay_time')->comment('支付时间');
            $table->string('user')->comment('用户标识');
            $table->string('target_order_id')->comment('第三方订单号');
            $table->string('order_number')->comment('平台订单号');
            $table->integer('buyer_pay_amount')->comment('实付金额');
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
        Schema::dropIfExists('pay_notices');
    }
}
