<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id')->comment('用户id');
            $table->string('name')->nullable()->default('')->comment('真实姓名');
            $table->string('sid')->unique()->comment('学号');
            $table->string('mobile')->nullable()->default('')->comment('手机号');
            $table->integer('is_admin')->default(0)->comment('是否是管理员');
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
