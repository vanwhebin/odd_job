<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type_id')->default(1)->comment('1 评价商户 2 评价零工');
            $table->foreignId('user_id')->comment('评价人')->constrained('users')->onDelete('cascade');
            $table->foreignId('marked_user_id')->comment('被评价人')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade')->nullOnDelete();
            $table->unsignedTinyInteger('satisfy')->default(1)->comment('是否合作满意');
            $table->json('tags')->nullable();
            $table->string('content')->nullable()->comment('自定义评价');
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
        Schema::dropIfExists('marks');
    }
}
