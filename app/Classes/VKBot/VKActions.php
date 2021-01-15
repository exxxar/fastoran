<?php


namespace App\Classes\VKBot;


use VK\Client\VKApiClient;

trait VKActions
{
    protected $base_keyboard = [
        [
            [
                "action" => [
                    "type" => "text",
                    "payload" => "{\"button\":\"identification_admin\"}",
                    "label" => "Запросить права администратора"
                ],
                "color" => "primary"
            ],

            [
                "action" => [
                    "type" => "text",
                    "payload" => "{\"button\":\"identification_delivery\"}",
                    "label" => "Запросить права доставщика"
                ],
                "color" => "secondary"
            ],

        ], [
            [
                "action" => [
                    "type" => "text",
                    "payload" => "{\"button\":\"identification_delivery\"}",
                    "label" => "Запросить подтверждение группы"
                ],
                "color" => "secondary"
            ],
        ],

        [
            [
                "action" => [
                    "type" => "text",
                    "payload" => "{\"button\":\"debug_message\"}",
                    "label" => "Запросить отладочной информации"
                ],
                "color" => "negative"
            ],
        ]
    ];


    protected $main_admin_keyboard = [
        [
            [
                "action" => [
                    "type" => "text",
                    "payload" => "{\"button\":\"request_update_products\"}",
                    "label" => "Заявка на обновление товара"
                ],
                "color" => "primary"
            ],

        ],

        [
            [
                "action" => [
                    "type" => "text",
                    "payload" => "{\"button\":\"debug_message\"}",
                    "label" => "Запросить отладочной информации"
                ],
                "color" => "negative"
            ],
        ]

    ];

    protected $request_keyboard = [
        [
            [
                "action" => [
                    "type" => "text",
                    "payload" => "{\"button\":\"%s\"}",
                    "label" => "%s"
                ],
                "color" => "primary"
            ],

            [
                "action" => [
                    "type" => "text",
                    "payload" => "{\"button\":\"%s\"}",
                    "label" => "%s"
                ],
                "color" => "negative"
            ],

        ],

    ];

    protected function preparedRequestKB($param_1_title, $param_1_value, $param_2_title, $param_2_value)
    {
        return json_decode(sprintf(json_encode($this->request_keyboard),
            $param_1_value,
            $param_1_title,
            $param_2_value,
            $param_2_title
        ));
    }

    public function sendRequestAdminKB($message, $vkUserId)
    {
        $this->sendMessageToChat(
            env("VK_FASTORAN_MAIN_ADMIN_CHANNEL"),
            $message,
            $this->preparedRequestKB(
                "Подтвердить администратора",
                "accept_admin_$vkUserId",
                "Отклонить администратора",
                "decline_admin_$vkUserId"
            ));
    }


    public function sendRequestChannelKB($message,$vkUserId)
    {
        $this->sendMessageToChat(
            env("VK_FASTORAN_MAIN_ADMIN_CHANNEL"),
            $message,
            $this->preparedRequestKB(
                "Подтвердить канал",
                "accept_channel_$vkUserId",
                "Отклонить канал",
                "decline_channel_$vkUserId"
            ));
    }

    public function sendRequestDeliverymanKB($message,$vkUserId)
    {
        $this->sendMessageToChat(
            env("VK_FASTORAN_MAIN_ADMIN_CHANNEL"),
            $message,
            $this->preparedRequestKB(
                "Подтвердить доставщика",
                "accept_deliveryman_$vkUserId",
                "Отклонить доставщика",
                "decline_deliveryman_$vkUserId"
            ));
    }


    public function sendMainKB($message)
    {
        $this->sendBaseMessageWithKeyboard($this->chatId, $message, $this->main_admin_keyboard, false);
    }

    public function sendMessage($message, $keyboard = null)
    {
        if (is_null($keyboard))
            $this->sendBaseMessageWithoutKeyboard($this->chatId, $message);
        else
            $this->sendBaseMessageWithKeyboard($this->chatId, $message, $keyboard, true);
    }

    public function sendMessageToChat($chatId, $message, $keyboard = null)
    {
        if (is_null($keyboard))
            $this->sendBaseMessageWithoutKeyboard($chatId, $message);
        else
            $this->sendBaseMessageWithKeyboard($chatId, $message, $keyboard, true);
    }

    public function sendBaseKB($message)
    {
        $this->sendBaseMessageWithKeyboard($this->chatId, $message, $this->base_keyboard, false);
    }

    public function sendInlineKB($message, $keyboard = [])
    {
        $this->sendBaseMessageWithKeyboard($this->chatId, $message, $keyboard, true);
    }

    public function sendBaseMessageWithKeyboard($chatId, $message, $keyboard = [], $inline = false)
    {
        $access_token = env("VK_SECRET_KEY");
        $vk = new VKApiClient();
        $vk->messages()->send($access_token, [
            'peer_id' => $chatId,
            'message' => $message,
            'random_id' => random_int(0, 10000000000),
            'keyboard' =>
                json_encode([
                    "one_time" => false,
                    'inline' => $inline,
                    "buttons" => $keyboard
                ])
        ]);
    }

    protected function sendBaseMessageWithoutKeyboard($chatId, $message)
    {
        $access_token = env("VK_SECRET_KEY");
        $vk = new VKApiClient();
        $vk->messages()->send($access_token, [
            'peer_id' => $chatId,
            'message' => $message,
            'random_id' => random_int(0, 10000000000),

        ]);
    }
}
