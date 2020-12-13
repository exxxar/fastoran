<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObedyGoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obedy_go_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('');
            $table->string('description')->nullable();
            $table->integer('day_index')->default(7);
            $table->string('image',1000)->default('');
            $table->double('price')->default(0);
            $table->double('weight')->default(0);
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('food_part_id')->nullable();
            $table->json('positions');
            $table->boolean('checked')->nullable();
            $table->boolean('is_week')->default(false);
            $table->boolean('addition')->default(false);
            $table->boolean('disabled')->nullable();

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
        Schema::dropIfExists('obedy_go_products');
    }
}
