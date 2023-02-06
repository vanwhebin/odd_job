<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable()->comment("会员编号");
            $table->string('name')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('avatar')->nullable()->comment("头像");
            $table->unsignedTinyInteger('sex')->default(1)->comment("性别 1 男 0 女");
            $table->date('birthday')->default('2002-01-01');
            $table->unsignedTinyInteger('age')->default(18);
            $table->string('province')->nullable()->comment('省份');
            $table->string('province_id')->nullable()->comment('省份编码');
            $table->string('city')->nullable()->comment('城市');
            $table->string('city_id')->nullable()->comment('城市编码');
            $table->string('area')->nullable()->comment('区域');
            $table->string('area_id')->nullable()->comment('区域编码');
            $table->string('weixin_openid')->unique()->nullable()->comment('用户微信标识');
            $table->string('weapp_openid')->nullable()->unique()->comment('用户小程序标识');
            $table->string('weixin_unionid')->unique()->nullable()->comment('用户微信平台唯一标识');
            $table->unsignedInteger('subscribe')->default(0)->comment('是否关注');
            $table->unsignedTinyInteger('complete')->default(0)->comment("资料完成度");
            $table->unsignedTinyInteger('vip')->default(0)->comment("vip");
            $table->unsignedTinyInteger('status')->default(1)->comment("状态 ");
            $table->timestamp('last_actived_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
