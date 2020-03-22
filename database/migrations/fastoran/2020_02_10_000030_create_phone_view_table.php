<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneViewTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'phone_view';

    /**
     * Run the migrations.
     * @table phone_view
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('ip', 18);
            $table->date('dat');
            $table->unsignedInteger('rest_id');
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
       Schema::dropIfExists($this->tableName);
     }
}
