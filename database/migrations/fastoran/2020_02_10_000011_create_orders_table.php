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

            $table->unsignedInteger('rest_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();

            $table->string('latitude')->nullable()->comment('широта');
            $table->string('longitude')->nullable()->comment('долгота');

            $table->unsignedInteger('deliveryman_id')->nullable();
            $table->string('deliveryman_latitude')->nullable()->comment('широта для доставщика');
            $table->string('deliveryman_longitude')->nullable()->comment('долгота для доставщика');

            $table->integer('status')->default(\App\Enums\OrderStatusEnum::InProcessing);
            $table->integer('order_type')->default(\App\Enums\OrderTypeEnum::FromRestoran);
            $table->boolean('take_by_self')->default(false);

            $table->integer('delivery_price')->default(0);
            $table->integer('changed_summary_price')->default(0);
            $table->integer('changed_delivery_price')->default(0);
            $table->integer('delivery_range')->default(0);
            $table->string('delivery_note', 2000)->default('');

            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone')->nullable();

            $table->string('receiver_delivery_time')->nullable();
            $table->string('receiver_address')->nullable();
            $table->string('receiver_order_note')->nullable();
            $table->string('receiver_domophone')->nullable();

            $table->string('client')->nullable();

            $table->json('custom_details')->nullable();


            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('rest_id')->references('id')->on('restorans');
                $table->foreign('user_id')->references('id')->on('users');
            }

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
