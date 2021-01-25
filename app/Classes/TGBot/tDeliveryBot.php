<?php


namespace App\Classes\TGBot;


use App\Enums\UserTypeEnum;

trait tDeliveryBot
{
    protected $main_menu_keyboard = [
        ["%s"],//я работаю \ не работаю
        ["Заказы за день"],
        ["Сменить статус"],
        ["Как пользоваться"],

    ];

    protected $main_super_menu_keyboard = [
        ["PDF-сводка за день"],
        ["Все заказы за день"],// возможность менять цену заказа и доставки
        ["Доставщики", "Администраторы"], //сделать возможность исключения из Админов и доставщиков, генерация кодов по заведениям
        ["Сменить статус"],
        ["Как пользоваться"],

    ];

    protected $fallback_keyboard = [
        ["Продолжить позже"],
    ];

    protected $fallback_keyboard_2 = [
        ["Попробовать опять"],
        ["Как пользоваться"],
    ];

    public function getMainMenu($message)
    {
        $user = $this->getUser();
        $is_work = $user->is_working;

        if ($user->user_type == UserTypeEnum::SuperAdmin) {

            if (is_null($user->phone))
                array_push($this->main_super_menu_keyboard, [
                    ["text" => "Отправить мой номер",
                        "request_contact" => true]
                ]);

            $this->sendMenu("Тип пользователя *Суперадмин*:\n" . $message, $this->main_super_menu_keyboard);
            return;
        }

        $this->main_menu_keyboard[0][0] = sprintf($this->main_menu_keyboard[0][0], $is_work ? "\xE2\x9D\x8EЯ не работаю" : "\xE2\x9C\x85Я работаю");

        if (is_null($user->phone))
            array_push($this->main_menu_keyboard, [
                ["text" => "Отправить мой номер",
                    "request_contact" => true]
            ]);

        if ($user->user_type == UserTypeEnum::Deliveryman)
            array_push($this->main_menu_keyboard[1], "Моя доставка");

        $this->sendMenu(($user->user_type == UserTypeEnum::Deliveryman ? "Тип пользователя *Доставщик:*\n" : "Тип пользователя *Администратор:*\n") . $message, $this->main_menu_keyboard);
    }

    public function getFallbackMenu($message)
    {
        $this->sendMenu($message, $this->fallback_keyboard);
    }

    public function getFallbackMenu2($message)
    {
        $this->sendMenu($message, $this->fallback_keyboard_2);
    }


}
