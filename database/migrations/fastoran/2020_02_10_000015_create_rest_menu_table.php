<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestMenuTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'rest_menus';

    /**
     * Run the migrations.
     * @table menu
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('food_name', 100)->default('');
            $table->text('food_remark')->default('');
            $table->integer('food_ext')->default(0);
            $table->integer('food_price')->default(0);
            $table->integer('time_to_prepare')->default(0);
            $table->integer('food_rating')->default(0);

            $table->unsignedInteger('rest_id');
            $table->unsignedInteger('food_category_id')->nullable();

            $table->string('food_img', 1000)->default('');

            $table->boolean('stop_list')->default(false);

            $table->unsignedInteger('rating_id')->nullable();

            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('rest_id')->references('id')->on('restorans');
                $table->foreign('food_category_id')->references('id')->on('menu_category');
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
       Schema::dropIfExists($this->tableName);
     }
}
