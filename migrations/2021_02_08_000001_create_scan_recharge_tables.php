<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanRechargeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 支付渠道
        Schema::create('scan_recharge_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('支付名称');
            $table->text('desc')->nullable()->comment('简介');
            $table->timestamps();
        });

        // 支付订单
        Schema::create('scan_recharge_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('scan_recharge_channel_id')->index()->comment('支付渠道');
            $table->unsignedBigInteger('user_id')->index()->comment('支付会员');
            $table->unsignedDecimal('amount')->comment('支付金额');
            $table->string('desc')->comment('备注');
            $table->string('reply')->nullable()->comment('回复');
            $table->boolean('status')->default(0)->comment('交易状态');
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
        Schema::dropIfExists('scan_recharge_channels');
        Schema::dropIfExists('scan_recharge_orders');
    }
}
