<?php


namespace App\Classes\TGBot;



trait tDeliveryBot
{
    protected $main_menu_keyboard = [
        ["\xE2\xAD\x90Мой профиль", "\xF0\x9F\x91\x9BКорзина(%s)"],
        ["\xF0\x9F\x91\xB8Lotus Model Agency"],
        ["\xF0\x9F\x93\xB7Lotus Photostudio", "\xF0\x9F\x8C\x9FLotus Kids"],
        ["\xF0\x9F\x8E\xAALotus Camp", "\xF0\x9F\x93\xB9Combo Photoproject"],
        ["\xF0\x9F\x92\x83Lotus Dance", "\xF0\x9F\x91\x95Фирменная продукция"],

        ["\xF0\x9F\x91\x89F.A.Q."],
    ];



    protected $admin_menu_keyboard = [
        ["\xF0\x9F\x94\xB8Управление товарами", "\xF0\x9F\x94\xB8Управление анкетами"],
        ["\xF0\x9F\x94\xB8Управление опросами", "\xF0\x9F\x94\xB8Управление вопросами"],
        ["\xF0\x9F\x94\xB8Управление фотопроектами"],
        ["\xF0\x9F\x94\xB8Статистика по боту"],
        ["\xF0\x9F\x93\xA3Каналы администраторов"],
        /*       ["\xF0\x9F\x93\xA9СМС Рассылки"],*/
        ["\xF0\x9F\x94\x99Главное меню"],
    ];



    protected $keyboard_fallback = [
        [
            "Продолжить позже"
        ],
    ];

    protected $keyboard_fallback_3 = [
        [
            "Продолжить позже"
        ],
        [
            ["text" => "Отправить мой номер",
            "request_contact" => true]
        ]
    ];

    public function getMainMenu($message)
    {
        $user = $this->getUser();
        $inBasketCount = 0;
        $this->main_menu_keyboard[0][1] = sprintf($this->main_menu_keyboard[0][1], $inBasketCount);
        $this->sendMenu($message, $this->main_menu_keyboard);
    }

    public function getAdminMenu($message)
    {
        $tmp_menu = $this->admin_menu_keyboard;
        $user = $this->getUser();
        if (!is_null($user))
            if ($user->is_admin) {
                $this->sendMenu($message, $tmp_menu);
                return;
            }
        $this->getMainMenu($message);
    }




    public function getFallbackMenu($message)
    {
        $this->sendMenu($message, $this->keyboard_fallback);
    }

    public function getFallbackMenuWithPhone($message)
    {
        $this->sendMenu($message, $this->keyboard_fallback_3);
    }

}
