<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no')->nullable()->comment('订单号');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('shop_id')->constrained('shops')->onDelete('cascade');
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->date('start_date')->comment('开始日期');
            $table->date('end_date')->comment('结束日期');
            $table->json('day_range')->nullable()->comment('日期范围');
            $table->time('start_time')->comment('开始时间');
            $table->time('end_time')->comment('结束时间');
            $table->unsignedTinyInteger('urgent')->default(0)->comment('加急');
            $table->unsignedInteger('amount')->default(1)->comment('工作人数');
            $table->decimal('wage',10,2)->default(0)->comment('时薪');
            $table->unsignedTinyInteger('meal')->default(0)->comment('是否含餐');
            $table->unsignedTinyInteger('age')->default(0)->comment('年龄要求');
            $table->unsignedTinyInteger('sex')->default(0)->comment('性别要求');
            $table->string('content')->nullable()->comment('工作要求');
            $table->decimal('total',10,2)->default(0)->comment('总金额');
            $table->dateTime('paid_at')->nullable()->comment('付款时间');
            $table->unsignedTinyInteger('rate')->nullable()->comment('评价');
            $table->unsignedTinyInteger('status')->default(0)->comment('订单状态 0待付款 1 已付款 2 已完成 3 已取消');
            $table->json('extra')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
