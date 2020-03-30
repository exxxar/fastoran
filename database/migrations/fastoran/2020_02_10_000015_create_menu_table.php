<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'menus';

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
            $table->text('food_remark');
            $table->integer('food_ext')->default(0);
            $table->integer('food_price')->default(0);

            $table->unsignedInteger('food_rubr_id');
            $table->unsignedInteger('food_razdel_id');
            $table->unsignedInteger('rest_id');
            $table->unsignedInteger('food_category_id');

            $table->string('food_img', 1000)->default('');

            $table->boolean('stop_list')->default(false);

            $table->unsignedInteger('rating_id');

            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('rest_id')->references('id')->on('restorans');
                $table->foreign('food_rubr_id')->references('id')->on('menu_rubrik');
                $table->foreign('food_razdel_id')->references('id')->on('menu_razdel');
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
