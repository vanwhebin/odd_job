<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('province')->comment('省份代码');
            $table->string('province_id')->comment('省份代码');
            $table->string('city')->comment('城市代码');
            $table->string('city_id')->comment('城市代码');
            $table->string('area')->comment('区域代码');
            $table->string('area_id')->comment('区域代码');
            $table->decimal('price',10,2)->default(22)->comment('区域价格');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态');
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
        Schema::dropIfExists('areas');
    }
}
