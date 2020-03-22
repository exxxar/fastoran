<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'discounts';

    /**
     * Run the migrations.
     * @table discounts
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name', 200);
            $table->string('img', 80);
            $table->unsignedInteger('rest_id');
            $table->date('dat');
            $table->integer('recurce');
            $table->integer('day');
            $table->date('from_dat');
            $table->unsignedInteger('likes_id');
            $table->integer('budnie');
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
