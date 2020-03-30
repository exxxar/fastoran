<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'kitchens';

    /**
     * Run the migrations.
     * @table kitchen
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name', 50)->default('');
            $table->string('img', 1000)->default('');
            $table->boolean('is_active')->default(true);
            $table->text('alt_description');

            $table->unsignedInteger('rating_id');

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
