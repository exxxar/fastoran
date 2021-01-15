<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHUBRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_u_b_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vk_user_id')->nullable();
            $table->string('vk_channel_id')->nullable();
            $table->string('comment')->nullable();
            $table->integer('request_type')->default(0);
            $table->boolean('is_confirmed')->default(false);
            $table->boolean('is_declined')->default(false);
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
        Schema::dropIfExists('h_u_b_requests');
    }
}
