<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuRubrikTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'menu_rubriks';

    /**
     * Run the migrations.
     * @table menu_rubrik
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name', 50);
            $table->unsignedInteger('rest_id');
            $table->unsignedInteger('cat_id');

            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('rest_id')->references('id')->on('restorans');
                $table->foreign('cat_id')->references('id')->on('menu_categories');
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
       Schema::dropIfExists($this->tableName);
     }
}
