<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportImgTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'report_img';

    /**
     * Run the migrations.
     * @table report_img
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('link', 80);
            $table->integer('report');
            $table->integer('rest');
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
