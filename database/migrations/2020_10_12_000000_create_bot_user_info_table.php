<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_user_info', function (Blueprint $table) {
            $table->increments('id');

            $table->string('chat_id')->nullable();
            $table->string('account_name')->default('');
            $table->string('fio')->default('');
            $table->string('phone')->nullable();

            $table->boolean('is_admin')->default(false);
            $table->boolean('is_developer')->default(false);
            $table->boolean('is_working')->default(false);
            $table->boolean('is_vip')->default(false);
            $table->double('cash_back')->default(0.0);

            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
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
