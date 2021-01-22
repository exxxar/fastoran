<?php


namespace App\Conversations;



use Illuminate\Support\Facades\Log;
use Laravel\BotCashBack\Models\BotUserInfo;

class StartDataConversation
{

    public static function start($bot, ...$d)
    {
        $bot->stopConversation();
        $data = isset($d[1]) ? $d[1] : null;

        $pattern = "/([0-9]{3})([0-9]{10})/";
        $string = base64_decode($data);

        $is_valid = preg_match_all($pattern, $string, $matches);

        if (!$is_valid) {
            $bot->mainMenu("Добро пожаловать в модельное агенство Lotus!");
            return;
        }

        $code = $matches[1][0];
        $request_id = $matches[2][0];

        $user = $bot->getUser();

        if (!$user->is_admin) {
            $bot->getMainMenu("Добро пожаловать в модельное агенство Lotus!");
            return;
        }

        if ($code === "001") {
            StartDataConversation::askForAction($bot, $request_id);

            $bot->startConversation("admin_action_handler");
            return;
        }

        if ($code === "002") {
            $ticket = Ticket::find(intval($request_id));
            if (is_null($ticket)) {
                $bot->reply("Вопрос #$request_id не найден!");
                return;
            }

            $keyboard = [
                [
                    ["text" => "Ответить на вопрос", "callback_data" => "/answer_this_questions $ticket->id"],
                ]
            ];
            $bot->sendMessage(
                sprintf("*Вопрос #%s:*\nИмя пользователя: %s\nТекст вопроса: \n_%s_\n",
                    $ticket->id,
                    $ticket->name,
                    $ticket->message
                ), $keyboard);
        }
    }

    public static function askForAction($bot, $user_id)
    {


        $keyboard = [
            [
                ["text" => "\xF0\x9F\x92\xA1Назначить администратора", "callback_data" => "action_admin_up"],

            ],
            [
                ["text" => "\xF0\x9F\x92\xA1Убрать администратора", "callback_data" => "action_admin_down"],
            ]

        ];


        $bot->sendMessage("Запрос действия администратора:", $keyboard);


        $bot->next("admin_action_handler", [
            "request_user_id" => $user_id,

        ]);
    }

    public static function actionHandler($bot, $message)
    {
        if (StartDataConversation::fallback($bot, $message))
            return;

        //    $bot->deleteMessage();

        switch ($message) {
            case "action_admin_up":
                StartDataConversation::admin($bot, $message, true);
                break;
            case "action_admin_down":
                StartDataConversation::admin($bot, $message, false);
                break;
        }

        $bot->stopConversation();
    }

    public static function admin($bot, $message, $up = true)
    {
        if (StartDataConversation::fallback($bot, $message))
            return;
        $user = $bot->getUser();

        if (!$user->is_admin) {
            $bot->stopConversation();
            $bot->getMainMenu("Вы не являетесь администратором!");
            return;
        }

        $request_user_id = $bot->storeGet("request_user_id");

        $requestUser = BotUserInfo::where("chat_id", intval($request_user_id))->first();

        $bot->reply("UserId=$request_user_id");
        if (is_null($requestUser)) {
            $bot->reply("Пользователь не найден!");
            $bot->next("admin_ask_for_action");
            return;
        }

        $requestUser->is_admin = $up;
        $requestUser->save();

        $bot->sendMessageToChat($requestUser->chat_id, $up ? "Вы назначены администратором!" : "Вы разжалованы из администраторов!");
        $bot->reply($up ? "Пользотваель #$requestUser->user_id назначен администратором!" :
            "Пользотваель #$requestUser->user_id разжалован из администраторов!"
        );
        $bot->next("admin_ask_for_action");
    }


    public static function fallback($bot, $message)
    {

        if ($message === "Продолжить позже") {
            $bot->getMainMenu("Хорошо! Продолжим позже!");

            $bot->stopConversation();
            return true;
        } else
            return false;
    }
}
