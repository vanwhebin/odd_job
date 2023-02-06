<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserClosureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_closure', function (Blueprint $table) {
            $table->unsignedInteger('ancestor');
            $table->unsignedInteger('descendant');
            $table->unsignedTinyInteger('distance');
            $table->primary(['ancestor', 'descendant']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_closure');
    }
}
