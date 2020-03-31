<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'comments';

    /**
     * Run the migrations.
     * @table comments
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('title',1000)->default('');
            $table->text('message');

            $table->boolean('in_moderation')->default(true);

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('rating_id')->nullable();

            $table->integer('content_type')->default(\App\Enums\ContentTypeEnum::Restoran);
            $table->unsignedInteger('content_id');

            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('user_id')->references('id')->on('users');
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
