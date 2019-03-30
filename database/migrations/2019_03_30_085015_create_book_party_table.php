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
            $table->string('speaker')->comment('主讲人');
            $table->string('place')->comment('地点');
            $table->text('summary')->comment('简介');
            $table->text('max_user')->comment('报名上限');
            $table->text('checkin_code')->comment('签到码')->unique();
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
