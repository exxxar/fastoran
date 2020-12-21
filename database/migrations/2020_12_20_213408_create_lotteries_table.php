<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image',1000);
            $table->string('title')->default('');
            $table->longText('description');
            $table->json('occuped_places')->nullable();
            $table->integer('place_count')->default(0);
            $table->unsignedInteger('win_promo_id')->nullable();
            $table->integer('free_place_count')->default(0);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_complete')->default(false);
            $table->date('date_end')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('lotteries');
    }
}
