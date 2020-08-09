<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestoransInSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('restorans_in_section', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('section_id');
            $table->unsignedInteger('restoran_id');

            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('section_id')->references('id')->on('sections');
                $table->foreign('restoran_id')->references('id')->on('restorans');
            }
            $table->timestamps();
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
        Schema::dropIfExists('restorans_in_section');
    }
}
