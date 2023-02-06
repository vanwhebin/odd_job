<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path')->comment('图片路径');
            $table->unsignedTinyInteger('type')->default(1)->comment('类型 1 图片,2 视频');
            $table->unsignedInteger('imagetable_id')->nullable()->comment('关联模型ID');
            $table->string('imagetable_type')->nullable()->comment('关联模型');
            $table->unsignedInteger('detail')->default(0)->comment('0,暂时无用 1内容图片');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('images');
    }
}
