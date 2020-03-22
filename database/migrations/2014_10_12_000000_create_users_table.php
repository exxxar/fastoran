<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');

            $table->string('name');
            $table->string('email')->unique();
            //$table->string('avatar')->default('avatar.png');

            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('active')->default(false);
            $table->string('activation_token');
            $table->string('password');

            $table->string('social', 100)->default('');
            $table->string('phone', 50)->default('');

            $table->dateTime('reg_dat');
            $table->integer('aut_code');
            $table->string('dostavka', 120);
            $table->integer('bonus');
            $table->string('famil', 80);
            $table->date('birthday');
            $table->string('user_city', 20);
            $table->string('user_home', 10);
            $table->string('user_flat', 5);
            $table->integer('user_region');
            $table->string('user_street', 30);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
