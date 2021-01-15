<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHubRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_hub_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vk_user_id')->nullable();
            $table->unsignedInteger('rest_id')->nullable();
            $table->string('rest_channel_id')->nullable();
            $table->string('admin_channel_id')->nullable();
            $table->string('delivery_channel_id')->nullable();
            $table->string('phone')->default('');
            $table->string('description')->default('');
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_deliveryman')->default(false);
            $table->boolean('is_main_admin')->default(false);
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
        Schema::dropIfExists('order_hub_rules');
    }
}
