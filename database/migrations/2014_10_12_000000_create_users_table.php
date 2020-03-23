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
            $table->string('class')->nullable()->default('')->comment('班级');
            $table->string('sid')->unique()->comment('学号');
            $table->string('mobile')->nullable()->default('')->comment('手机号');
            $table->integer('institute_id')->nullable()->default(0)->comment('学院id');
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
