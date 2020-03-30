<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuRazdelTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'menu_razdels';

    /**
     * Run the migrations.
     * @table menu_razdel
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

            $table->unsignedInteger('rubr_id');
            $table->unsignedInteger('rest_id');

            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('rubr_id')->references('id')->on('menu_rubriks');
                $table->foreign('rest_id')->references('id')->on('restorans');
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
