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
            $table->integer('category')->comment('Категория заведения');
            $table->string('adress', 200)->comment('адрес');
            $table->string('orientir', 100)->comment('ориентир');
            $table->integer('city')->comment('город');
            $table->unsignedInteger('region_id')->comment('район');
            $table->string('phone1', 50)->comment('Телефон1');
            $table->string('phone2', 50)->comment('Телефон2');
            $table->string('www', 50)->comment('сайт');
            $table->string('mail', 50)->comment('email');
            $table->string('tim', 50)->comment('Время работы');
            $table->integer('checkout')->comment('Средний чек');
            $table->integer('dance')->comment('Танцпол');
            $table->integer('karaoke')->comment('Караоке');
            $table->integer('wifi')->comment('wifi');
            $table->integer('bussines')->comment('Бизнес ланчи');
            $table->integer('parking')->comment('Парковка');
            $table->integer('children')->comment('Детское меню');
            $table->text('remark')->comment('Описание');
            $table->string('cont_face', 120)->comment('Контактное лицо');
            $table->string('cont_phone', 50)->comment('Контактный телефон');
            $table->string('vk_page', 120)->comment('Страница Вконтакте');
            $table->string('odn_page', 120)->comment('Старница Однокласники');
            $table->string('inst_page', 120)->comment('Страница Инстаграмм');
            $table->integer('manager')->comment('Менеджер в ресте');
            $table->string('logo', 1000)->comment('Логотип заведения');
            $table->integer('money')->comment('Баланс заведения');
            $table->integer('rating')->comment('Рейтинг заведения');
            $table->string('seo_domen', 50)->comment('Домен заведения');
            $table->string('seo_title', 120)->comment('title заведения');
            $table->string('seo_h1', 130)->comment('h1 заведения');
            $table->string('seo_description', 245)->comment('description заведения');
            $table->string('url', 50)->comment('Короткий адрес заведения');
            $table->integer('view')->comment('Кол-во просмотров');
            $table->integer('comments')->comment('Кол-во отзывов');
            $table->integer('images')->comment('Кол-во фото ');
            $table->date('reg_dat')->comment('Дата регистрации');
            $table->integer('rest_like')->comment('кол-во like');
            $table->integer('rest_antilike');
            $table->string('rest_img', 120);
            $table->boolean('moderation')->default(true);
            $table->integer('tarif');
            $table->string('fav', 80);
            $table->string('count_people', 20);
            $table->integer('special');
            $table->integer('discount');
            $table->string('dir_mail', 35);
            $table->string('bron_phone', 80);
            $table->text('discount_text');
            $table->integer('phone_view');
            $table->integer('child');
            $table->integer('min_sum');
            $table->string('price_delivery', 40);
            $table->string('time_delivery', 20);
            $table->string('filters', 40);
            $table->integer('fastoran_money');
            $table->integer('sms');
            $table->string('start_lanch', 8);
            $table->string('end_lanch', 8);

            if (env("DB_CONNECTION") == 'mysql') {
                $table->foreign('region_id')->references('id')->on('region');
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
