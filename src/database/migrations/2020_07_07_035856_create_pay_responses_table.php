<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_responses', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->comment('订单号');
            $table->string('target_order_id')->comment('第三方订单号');
            $table->text('content')->comment('支付通知信息详细');
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
        Schema::dropIfExists('pay_responses');
    }
}
