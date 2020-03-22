<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'orders';

    /**
     * Run the migrations.
     * @table orders
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');

            $table->unsignedInteger('rest_id');
            $table->unsignedInteger('user_id');

            $table->integer('summ')->default(0);
            $table->integer('pers')->default(1);
            $table->date('dat');
            $table->time('tim');
            $table->text('remark');
            $table->integer('gosti');
            $table->integer('sdacha');
            $table->integer('delivery_price');
            $table->integer('status');
            $table->string('delivery_range', 10);

            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_region')->nullable();
            $table->string('receiver_delivery_time')->nullable();
            $table->string('receiver_address')->nullable();
            $table->string('receiver_pers')->nullable();
            $table->string('receiver_order_note')->nullable();
            $table->string('receiver_domophone')->nullable();


            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('rest_id')->references('id')->on('restorans');
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
