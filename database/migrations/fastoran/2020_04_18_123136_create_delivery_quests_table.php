<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryQuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('delivery_quests', function (Blueprint $table) {
            $table->increments('id');
            $table->json('point_a')->nullable();
            $table->json('point_b')->nullable();
            $table->unsignedInteger('next_quest_id')->nullable();
            $table->integer('quest_type')->default(0);
            $table->string('description',1000)->default('');
            $table->double('range')->default(0);
            $table->integer('price')->default(0);
            $table->unsignedInteger('order_id')->nullable();

         /*    if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('order_id')->references('id')->on('orders');
            }*/

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_quests');
    }
}
