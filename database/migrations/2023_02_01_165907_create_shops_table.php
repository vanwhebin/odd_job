<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->comment('店铺名称');
            $table->foreignId('user_id')->comment('门店管理')->constrained('users')->onDelete('cascade');
            $table->foreignId('relate_id')->nullable()->comment('门店关联人员,上级')->constrained('shops')->nullOnDelete();
            $table->string('cert')->default('')->comment('营业执照');
            $table->string('cert_no')->default('')->comment('营业执照号码');
            $table->string('cert_title')->default('')->comment('公司名称');
            $table->string('photo')->default('')->comment('门头照片');
            $table->string('real_name')->default('')->comment('真实姓名');
            $table->string('ID_card_no')->default('')->comment('身份证号');
            $table->unsignedTinyInteger('type')->default(1)->comment('行业分类');
            $table->string('province')->default('')->comment('省');
            $table->string('province_id')->comment('省');
            $table->string('city')->default('');
            $table->string('city_id')->default('');
            $table->string('area')->default('');
            $table->string('area_id')->default('');
            $table->string('address')->default('')->comment('地址');
            $table->string('phone')->comment('用户电话');
            $table->decimal('wallet',10,2)->default(0)->comment('总部可用余额');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 0 待审核 1 正常 2 驳回');
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
        Schema::dropIfExists('shops');
    }
}
