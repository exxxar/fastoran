<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitchenInRestoransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen_in_restorans', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('kitchen_id');
            $table->unsignedInteger('restoran_id');

            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('kitchen_id')->references('id')->on('kitchen');
                $table->foreign('restoran_id')->references('id')->on('restorans');
            }
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
        Schema::dropIfExists('kitchen_in_restorans');
    }
}
