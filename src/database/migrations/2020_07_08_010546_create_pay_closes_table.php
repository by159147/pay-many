<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayClosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_closes', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->comment('撤销订单号');
            $table->string('target_order_id')->nullable()->comment('撤销订单号 第三方');
            $table->string('ori_order_number')->nullable()->comment('原始订单号');
            $table->string('ori_target_order_id')->comment('原平台订单号');
            $table->string('user')->nullable()->comment('撤销发起人');
            $table->string('platform_close')->nullable()->comment('撤销发起平台');
            $table->text('content_response')->nullable()->comment('撤销响应');
            $table->text('content_request')->nullable()->comment('撤销请求');
            $table->tinyInteger('status')->default(1)->comment('状态 1待撤销 2已撤销');
            $table->unique('order_number');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `pay_closes` comment '撤销订单表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_closes');
    }
}
