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
            $table->string('phone')->unique();
            $table->integer('auth_code')->nullable();
            $table->integer('user_type')->default(\App\Enums\UserTypeEnum::User);

            $table->string('telegram_chat_id')->nullable();

            $table->date('birthday')->nullable();

            $table->integer('bonus')->default(0);

            $table->string('adress', 20)->default('');

            $table->string('social', 100)->default('');

            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('active')->default(false);
            $table->string('activation_token');
            $table->string('password');

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
