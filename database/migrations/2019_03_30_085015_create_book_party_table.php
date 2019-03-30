<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookPartyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_party', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('报名会id');
            $table->string('title')->comment('标题');
            $table->string('speaker')->default('')->comment('主讲人');
            $table->string('place')->default('')->comment('地点');
            $table->date('start_time')->comment('开始时间');
            $table->text('summary')->comment('简介');
            $table->integer('max_user')->comment('报名上限');
            $table->string('checkin_code')->unique()->comment('签到码');
            $table->integer('status')->default(0)->comment('状态，0正常，1关闭');
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
        Schema::dropIfExists('book_party');
    }
}
