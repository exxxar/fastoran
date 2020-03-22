<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiviveryPriceTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'divivery_price';

    /**
     * Run the migrations.
     * @table divivery_price
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('rest');
            $table->integer('r_1');
            $table->integer('r_3');
            $table->integer('r_9');
            $table->integer('r_5');
            $table->integer('r_8');
            $table->integer('r_6');
            $table->integer('r_2');
            $table->integer('r_7');
            $table->integer('r_4');
            $table->integer('r_10');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
