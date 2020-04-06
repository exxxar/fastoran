<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestoransTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'restorans';

    /**
     * Run the migrations.
     * @table restorans
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name', 150)->comment('Название заведения');
            $table->text('description')->comment('Описание');

            $table->string('adress', 200)->default('')->comment('адрес');
            $table->string('orientir', 100)->default('')->comment('ориентир');

            $table->string('city')->default('')->comment('город');

            $table->string('region')->default('')->comment('район');

            $table->string('latitude')->nullable()->comment('широта');
            $table->string('longitude')->nullable()->comment('долгота');

            $table->string('phone1', 50)->default('')->comment('Телефон1');
            $table->string('phone2', 50)->default('')->comment('Телефон2');
            $table->string('site', 50)->default('')->comment('сайт');

            $table->string('email', 50)->default('')->comment('email');
            $table->string('work_time', 50)->default('10:00-20:00')->comment('Время работы');

            $table->boolean('has_dance')->default(false)->comment('Танцпол');
            $table->boolean('has_karaoke')->default(false)->comment('Караоке');
            $table->boolean('has_wifi')->default(true)->comment('wifi');
            $table->boolean('has_parking')->default(true)->comment('Парковка');
            $table->boolean('has_business')->default(true)->comment('Бизнес ланчи');
            $table->boolean('has_children')->default(true)->comment('Детское меню');
            $table->boolean('has_special')->default(false)->comment('Спец. предложение');


            $table->string('telegram_channel', 120)->default('')->comment('Канал в телеграм');
            $table->string('cont_face', 120)->default('')->comment('Контактное лицо');
            $table->string('cont_phone', 50)->default('')->comment('Контактный телефон');
            $table->string('vk_page', 120)->default('')->comment('Страница Вконтакте');
            $table->string('odn_page', 120)->default('')->comment('Старница Однокласники');
            $table->string('inst_page', 120)->default('')->comment('Страница Инстаграмм');


            $table->string('logo', 1000)->comment('Логотип заведения');

            $table->integer('rest_rating')->default(0)->comment('Рейтинг заведения');

            $table->string('seo_domain', 50)->default('')->comment('Домен заведения');
            $table->string('seo_title', 120)->default('')->comment('title заведения');

            $table->string('seo_h1', 130)->default('')->comment('h1 заведения');
            $table->string('seo_description', 245)->default('')->comment('description заведения');

            $table->string('url', 50)->default('')->comment('Короткий адрес заведения');
            $table->integer('view_count')->default(0)->comment('Кол-во просмотров');


            $table->string('rest_img', 1000)->default('');

            $table->boolean('moderation')->default(true);

            $table->integer('tarif')->default(0);

            $table->integer('discount')->default(0);

            $table->string('dir_mail', 35)->default('');

            $table->text('discount_text')->default('');

            $table->integer('min_sum')->default(0);
            $table->integer('price_delivery')->default(0);

            $table->integer('fastoran_money')->default(0);

            $table->unsignedInteger('rating_id')->nullable();
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
