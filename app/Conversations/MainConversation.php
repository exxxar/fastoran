<?php


namespace App\Conversations;


use App\BotUserInfo;

use App\Enums\OrderStatusEnum;
use App\Enums\UserTypeEnum;
use App\Events\SendSmsEvent;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\Restoran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class MainConversation extends Conversation
{

    public static function start($bot)
    {
        $bot->stopConversation();

        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Введите ключевое слово!");
            $bot->startConversation("keyword_ask");
            return;
        }

        $bot->getMainMenu("Добро пожаловать в Систему правления заказами Fastoran!");
    }

    public static function keyword($bot, $message)
    {
        $bot->reply("Вы ввели: *$message*");
        $user = $bot->getUser();
        $rest = Restoran::where("keyword", $message)->first();

        if (is_null($rest) &&
            strtolower($message) !== strtolower(env("FASTORAN_DELIVERYMAN_KEYWORD"))) {
            $bot->reply("Неверный код, попробуйте другой!");
            $bot->next("keyword_ask");
            return;
        }

        if (strtolower($message) === strtolower(env("FASTORAN_DELIVERYMAN_KEYWORD"))) {
            $user->user_type = 1;
            $user->save();

            $keyboard = [
                [
                    ["text" => "\xF0\x9F\x93\x8DДонецк", "callback_data" => "Донецк"], ["text" => "\xF0\x9F\x93\x8DМакеевка", "callback_data" => "Макеевка"],
                ],
                [
                    ["text" => "\xF0\x9F\x93\x8DЯсиноватая", "callback_data" => "Ясиноватая"], ["text" => "\xF0\x9F\x93\x8DХарцызск", "callback_data" => "Харцызск"],
                ]
            ];


            $bot->reply("Вы ставли доставщиком, теперь выберите город в котором работаете!", $keyboard);

            $bot->next("keyword_city");
            return;
        }

        $user->user_type = 2;
        $user->rest_id = $rest->id;
        $user->save();
        $bot->stopConversation();
        $bot->getMainMenu(sprintf("Спасибо! Вы стали Администратором заведения %s!",
            $rest->name
        ));
    }

    public static function selectCity($bot, $message)
    {
        $cities = ["Донецк", "Макеевка", "Ясиноватая", "Харцызск"];

        if (!in_array($message, $cities)) {
            $bot->reply("Введите свой город:");
            $bot->next("keyword_city");
            return;
        }

        $user = $bot->getUser();
        $user->delivery_city = $message;
        $user->save();

        $bot->stopConversation();
        $bot->getMainMenu(sprintf("Спасибо! Вы выбрали основной город доставки %s",
            $message
        ));

    }

    public static function isWork($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $user->is_working = true;
        $user->save();
        $bot->getMainMenu("Ваш статус изменен на *работаю*");

    }

    public static function isNotWork($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $user->is_working = false;
        $user->save();
        $bot->getMainMenu("Ваш статус изменен на *не работаю*");
    }

    public static function changeUserType($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }


        $user->user_type = 0;
        $user->is_working = false;
        $user->save();
        $bot->getFallbackMenu("Введите ключевое слово!");
        $bot->startConversation("keyword_ask");
    }

    public static function faq($bot)
    {
        $user = $bot->getUser();

        $bot->reply("Как пользоваться:\n https://telegra.ph/FASTORAN-BOT-01-24");
    }

    public static function myDeliveryOrders($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orders = Order::with(["details", "restoran", "details.product", "user"])
            ->where("deliveryman_id", $user->user_id)
            ->where("status", OrderStatusEnum::InDeliveryProcess)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->get();

        if (count($orders) == 0) {
            $bot->reply("Список заказов пуст!");
            return;
        }

        foreach ($orders as $key => $order) {

            $delivery_order_tmp = "";
            foreach ($order->details as $detail) {
                $product = $detail->product_details;
                $local_tmp = sprintf("%s %s шт. %s руб.\n",
                    $product->food_name ?? "не указано",
                    $detail->count,
                    $product->food_price ?? "не указано"
                );

                $delivery_order_tmp .= $local_tmp;
            }

            $custom_details = "";
            if (count($order->custom_details) > 0) {
                foreach ($order->custom_details as $detail) {
                    $local_tmp = sprintf("%s - %s руб.\n",
                        $detail->name,
                        $detail->price
                    );
                    $custom_details .= $local_tmp;
                }
            }

            $message = sprintf("*Заявка #%s*\nРесторан:_%s_\nАдрес ресторана: %s\nФ.И.О.: _%s_\nТелефон заказчика:_%s_\nВремя доставки: _%s_\nАдрес доставки:_%s_\nЗаказ:\n%s\nЗаметка к заказу:%s\nВремя готовности: %s минут\n*Дополнение к заказу:*\n%s\nЦена заказа:*%s руб.*\nЦена доставки:*%s руб. (Расстояние %s км)*\n",
                $order->id,
                $order->restoran->name ?? "не указано",
                $order->restoran->adress ?? "не указано",
                $order->user->name ?? "имя не указано",
                $order->receiver_phone ?? "не указано",
                $order->receiver_delivery_time ?? "По готовности",
                $order->receiver_address ?? "не указано",
                $delivery_order_tmp,
                $order->order->receiver_order_note ?? "",
                $order->delivery_note ?? "не указано",
                $custom_details ?? "нет",
                $order->summary_price ?? "не указано",
                $order->delivery_price ?? "не указано",
                $order->delivery_range ?? "не указано"
            );


            $keyboard_deliveryman = [
                [

                    ["text" => "Успешно доставил", "callback_data" => "/delivered " . ($order->id)]
                ],
                [

                    ["text" => "Отказаться от заказа", "callback_data" => "/decline_delivery " . ($order->id)]
                ]
            ];


            $bot->reply(
                $message,
                $keyboard_deliveryman
            );
        }
    }

    public static function day($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orders = $user->user_type == UserTypeEnum::Admin ?
            Order::with(["details", "restoran", "details.product", "user"])
                ->where("rest_id", $user->rest_id)
                ->whereIn("status", [OrderStatusEnum::InProcessing, OrderStatusEnum::InQueue])
                ->where('created_at', '>', Carbon::now()->subDay())
                ->get() :
            Order::with(["details", "restoran", "details.product", "user"])
                ->whereNull("deliveryman_id")
                ->where("status", OrderStatusEnum::GettingReady)
                ->where('created_at', '>', Carbon::now()->subDay())
                ->get();


        if (count($orders) == 0) {
            $bot->reply("Список заказов пуст!");
            return;
        }

        foreach ($orders as $key => $order) {

            $delivery_order_tmp = "";
            foreach ($order->details as $detail) {
                $product = $detail->product_details;
                $local_tmp = sprintf("%s %s шт. %s руб.\n",
                    $product->food_name ?? "не указано",
                    $detail->count,
                    $product->food_price ?? "не указано"
                );

                $delivery_order_tmp .= $local_tmp;
            }

            $custom_details = "";
            if (count($order->custom_details) > 0) {
                foreach ($order->custom_details as $detail) {
                    $local_tmp = sprintf("%s - %s руб.\n",
                        $detail->name,
                        $detail->price
                    );
                    $custom_details .= $local_tmp;
                }
            }

            $message_admin = sprintf("*Заявка #%s*\nРесторан:_%s_\nАдрес ресторана: %s\nФ.И.О.: _%s_\nТелефон заказчика:_%s_\nВремя доставки: _%s_\nАдрес доставки:_%s_\nЗаказ:\n%s\nЗаметка к заказу:%s\nВремя готовности: %s\n*Дополнение к заказу:*\n%s\nЦена заказа:*%s руб.*\n",
                $order->id,
                $order->restoran->name ?? "не указано",
                $order->restoran->adress ?? "не указано",
                $order->user->name ?? "имя не указано",
                $order->receiver_phone ?? "не указано",
                $order->receiver_delivery_time ?? "По готовности",
                $order->receiver_address ?? "не указано",
                $delivery_order_tmp,
                $order->order->receiver_order_note ?? "",
                (($order->delivery_note ?? "не указано") . " минут"),
                $custom_details ?? "нет",
                $order->summary_price ?? "не указано"
            );

            $message_deliveryman = sprintf("%s\nЦена доставки:*%s руб. (Расстояние %s км)*\n",
                $message_admin,
                $order->delivery_price ?? "не указано",
                $order->delivery_range ?? "не указано"
            );


            $keyboard_deliveryman = [

                [

                    ["text" => "Отказаться от заказа", "callback_data" => "/decline_delivery " . ($order->id)]
                ]
            ];


            array_push($keyboard_deliveryman,
                is_null($order->deliveryman_id) ?
                    [["text" => "Начать доставку заказа!", "callback_data" => "/accept_order $order->id"]] :
                    [["text" => "Подтвердить доставку", "callback_data" => "/delivered " . ($order->id)]]
            );


            $keyboard_admin = [
                [
                    ["text" => "Передать в доставку", "callback_data" => "/set_time_and_accept " . ($order->id)],

                ],
                [
                    ["text" => "Отклонить заказ", "callback_data" => "/decline_order " . ($order->id)],
                ]
            ];

            $bot->reply(
                $user->user_type == UserTypeEnum::Deliveryman ?
                    $message_deliveryman :
                    $message_admin,
                $user->user_type == UserTypeEnum::Deliveryman ?
                    $keyboard_deliveryman :
                    $keyboard_admin
            );


        }
    }

    public static function acceptOrder($bot, ...$d)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orderId = isset($d[1]) ? intval($d[1]) : 0;
        $time = isset($d[2]) ? intval($d[2]) : null;

        Log::info(print_r($d, true));
        $order = Order::with(["restoran"])
            ->where("id", $orderId)
            ->first();

        $user = $bot->getUser();

        $validator = Validator::make(
            [
                "user" => $user,
                "order" => $order,
            ],
            [
                'user' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value->user_type === 0) {
                            $fail('Пользователь не является доставщиком или администратором');
                        }
                    },
                ],
                'order' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!is_null($value->deliveryman_id)) {
                            $fail('Заказ уже взят доставщиком!');
                        }
                    },
                ]

            ],
            [
                'user.required' => 'Пользователь не найден',
                'order.required' => 'Заказ не найден',
            ]);


        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $error)
                $bot->reply("Ошибочка...." . $error[0]);
            return;
        }


        $order->status = $user->user_type == UserTypeEnum::Deliveryman ?
            OrderStatusEnum::InDeliveryProcess :
            OrderStatusEnum::GettingReady;
        $order->deliveryman_id = $user->user_type == UserTypeEnum::Deliveryman ? $user->user_id : null;
        if (!is_null($time))
            $order->delivery_note = $time;
        $order->save();

        $message = sprintf(($user->user_type === UserTypeEnum::Deliveryman ?
            "Заказ *#%s* (%s) взят доставщиком *#%s (%s)*" :
            "Заказ *#%s* (%s) помечен как 'взят' администратором *#%s (%s)*"),
            $order->id,
            $order->receiver_phone,
            $user->user_id,
            $user->fio ?? "Без имени"
        );

        $bot->sendMessageToChat(env("TELEGRAM_FASTORAN_ADMIN_CHANNEL"), $message);

        $bot->reply($message);

        $bot->editReplyKeyboard();

        event(new SendSmsEvent($order->receiver_phone, "Ваш #$order->id заказ готовится!"));

        if ($user->user_type == UserTypeEnum::Admin) {
            $restCity = (Restoran::where("id", $order->rest_id)->first())->city ?? 'Донецк';

            $users = BotUserInfo::where("rest_id", $order->rest_id)
                ->where("user_type", UserTypeEnum::Deliveryman)
                ->where("delivery_city", $restCity)
                ->where("is_working", true)
                ->get();

            if (count($users) == 0)
                return;

            foreach ($users as $user) {
                $bot->sendMessageToChat($user->chat_id, $message, [
                    [
                        ["text" => "Начать доставку заказа!", "callback_data" => "/accept_order $orderId"],

                    ], [
                        ["text" => "Отменить доставку заказ!", "callback_data" => "/decline_order $orderId"]
                    ]
                ]);
            }
        }


    }

    public static function setTimeAndAccept($bot, ...$d)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orderId = isset($d[1]) ? intval($d[1]) : 0;

        $bot->reply("Выберите время доставки, в минутах:", [
            [
                ["text" => "5 мин", "callback_data" => "/accept_time_order $orderId 5"],
                ["text" => "10 мин", "callback_data" => "/accept_time_order $orderId 10"],
                ["text" => "15 мин", "callback_data" => "/accept_time_order $orderId 15"],
                ["text" => "25 мин", "callback_data" => "/accept_time_order $orderId 25"],
            ],
            [
                ["text" => "30 мин", "callback_data" => "/accept_time_order $orderId 30"],
                ["text" => "40 мин", "callback_data" => "/accept_time_order $orderId 40"],
                ["text" => "60 мин", "callback_data" => "/accept_time_order $orderId 60"],
                ["text" => "90 мин", "callback_data" => "/accept_time_order $orderId 90"],
            ]
        ]);
    }

    public static function declineOrder($bot, ...$d)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orderId = isset($d[1]) ? intval($d[1]) : 0;

        $order = Order::with(["restoran"])
            ->where("id", $orderId)
            ->first();

        $user = $bot->getUser();


        $validator = Validator::make(
            [
                "user" => $user,
                "order" => $order,
            ],
            [
                'user' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value->user_type === 0) {
                            $fail('Пользователь не является доставщиком или администратором');
                        }
                    },
                ],
                'order' => [
                    'required',
                    function ($attribute, $value, $fail) use ($user) {
                        if (is_null($user)) {
                            $fail("Ошибка валидации пользователя");
                            return false;
                        }

                        if ($user->user_type === UserTypeEnum::Admin)
                            return true;


                        if ($value->deliveryman_id !== $user->user_id) {
                            $fail(sprintf("Заказ #%s не принадлежит доставщику #%s",
                                $value->id,
                                $user->id
                            ));
                        }
                    },
                ]

            ],
            [
                'user.required' => 'Пользователь не найден',
                'order.required' => 'Заказ не найден',
            ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $error)
                $bot->reply("Ошибочка...." . $error[0]);
            $bot->editReplyKeyboard();
            return;
        }

        $order->status = $user->user_type === UserTypeEnum::Deliveryman ?
            OrderStatusEnum::InProcessing :
            OrderStatusEnum::DeclineByAdmin;
        $order->deliveryman_id = null;
        $order->save();


        $message = sprintf(($user->user_type === UserTypeEnum::Deliveryman ?
            "Доставщик *#%s* отказася от заказа *#%s*" :
            "Администратор *#%s* установил пометку 'отказ' к заказу *#%s*"),
            $user->id,
            $order->id
        );

        $bot->reply($message);
        $bot->sendMessageToChat(env("TELEGRAM_FASTORAN_ADMIN_CHANNEL"), $message);
        $bot->editReplyKeyboard();


    }

    public static function delivered($bot, ...$d)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orderId = isset($d[1]) ? intval($d[1]) : 0;

        $order = Order::with(["restoran", "user"])
            ->where("id", $orderId)
            ->first();

        $user = $bot->getUser();

        $validator = Validator::make(
            [
                "user" => $user,
                "order" => $order,
            ],
            [
                'user' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value->user_type === 0) {
                            $fail('Пользователь не является доставщиком или администратором');
                        }
                    },
                ],
                'order' => [
                    'required',
                    function ($attribute, $value, $fail) use ($user) {
                        if (is_null($user)) {
                            $fail("Ошибка валидации пользователя");
                            return;
                        }

                        if ($user->user_type === UserTypeEnum::Admin)
                            return;

                        if ($value->deliveryman_id !== $user->user_id) {
                            $fail(sprintf("Заказ #%s не принадлежит доставщику #%s",
                                $value->id,
                                $user->user_id
                            ));
                        }
                    },
                ]

            ],
            [
                'user.required' => 'Пользователь не найден',
                'order.required' => 'Заказ не найден',
            ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $error)
                $bot->reply("Ошибочка...." . $error[0]);
            return;
        }

        $order->status = OrderStatusEnum::Delivered;
        $order->save();

        $message = sprintf($user->user_type === UserTypeEnum::Deliveryman ?
            "Доставщик *#%s* успешно доставил заказ *#%s*" :
            "Администратор *#%s* установил пометку 'доставлено' к заказу *#%s*",
            $user->user_id,
            $order->id
        );


        if (!is_null($order->user->phone))
            event(new SendSmsEvent($order->user->phone, "Ваш заказ доставлен! https://fastoran.com"));

        $bot->reply($message);
        $bot->sendMessageToChat(env("TELEGRAM_FASTORAN_ADMIN_CHANNEL"), $message);


        $users = BotUserInfo::where("rest_id", $order->rest_id)
            ->where("user_type", UserTypeEnum::Admin)
            ->where("is_working", true)
            ->get();

        if (count($users) == 0)
            return;

        foreach ($users as $user)
            $bot->sendMessageToChat($user->chat_id, $message);

        $bot->editReplyKeyboard();

    }


}
