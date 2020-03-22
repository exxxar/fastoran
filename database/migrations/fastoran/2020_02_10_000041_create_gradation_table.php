<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradationTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'gradation';

    /**
     * Run the migrations.
     * @table gradation
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('rest');
            $table->integer('1_min_summ');
            $table->integer('1_min_money');
            $table->integer('1_max_summ');
            $table->integer('1_max_money');
            $table->integer('2_min_summ');
            $table->integer('2_min_money');
            $table->integer('2_max_summ');
            $table->integer('2_max_money');
            $table->integer('3_min_summ');
            $table->integer('3_min_money');
            $table->integer('3_max_summ');
            $table->integer('3_max_money');
            $table->integer('4_min_summ');
            $table->integer('4_min_money');
            $table->integer('4_max_summ');
            $table->integer('4_max_money');
            $table->integer('km_price');
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
