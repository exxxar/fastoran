<?php


namespace App\Classes\TGBot;



use App\BotUserInfo;
use App\Conversations\Conversation;
use App\User;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

use Illuminate\Support\Facades\Log;


use Symfony\Component\HttpFoundation\JsonResponse;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\InputMedia\InputMediaPhoto;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\TelegramRequest;


abstract class AbstractBot
{
    use tBotConversation, tDeliveryBot, tBotWebStorage, tBotStorage;

    protected $bot;

    protected $list;

    protected $current_ask;

    protected $query;

    protected $telegram_user;

    protected $bot_params;

    protected $message_id;

    protected $contact;


    private function hears($path, $func)
    {
        array_push($this->list, ["path" => $path, "function" => $func]);

        return $this;
    }

    private function fall($func, $message = null)
    {
        $this->current_ask[$this->last_method_id - 1]["fallback"] = $func;
        $this->current_ask[$this->last_method_id - 1]["error_message"] = $message;

        return $this;
    }

    private function where($pattern)
    {
        $this->current_ask[$this->last_method_id - 1]["pattern"] = trim($pattern);

        return $this;
    }

    private function ask($name, $func, $hideKeyboard = true)
    {
        $this->last_method_id = array_push($this->current_ask,
            [
                "name" => $name,
                "func" => $func,
                "hide" => $hideKeyboard,
                "pattern" => null,
                "fallback" => null,
            ]);
        return $this;
    }

    private function fallback($func)
    {
        array_push($this->list, ["path" => null, "function" => $func]);
        return $this;
    }

    public function getWebhookUpdates()
    {
        return $this->bot->getWebhookUpdates();
    }


    public function initBot($token = null)
    {
        $this->list = [];

        $this->current_ask = [];

        try {

            $this->bot = new Api(is_null($token) ? (config("app.debug") ?
                env("TELEGRAM_DEBUG_BOT") :
                env("TELEGRAM_PRODUCTION_BOT")) : $token
                , false);


        } catch (TelegramSDKException $e) {
            $this->bot = null;
        }

        if (!is_null($this->bot)) {
            include_once base_path('routes/bot.php');
            include_once base_path('routes/conversations.php');
        }
        return $this;
    }

    public function setTelegramUser($data)
    {
        $this->telegram_user = (object)[
            "id" => $data->id,
            "first_name" => $data->first_name ?? '',
            "last_name" => $data->last_name ?? '',
            "username" => $data->username ?? '',
        ];
    }

    public function handler($data)
    {
        $update = json_decode($data);
        $this->contact = null;


        if (isset($update->message->via_bot))
            return;


        if (isset($update->message->contact))
            $this->contact = $update->message->contact->phone_number;

        if (isset($update->inline_query))
            $this->inlineQueryHandler($update->inline_query);

        if (isset($update->channel_post))
            return;

        $this->message_id = $update->message->message_id ?? $update->callback_query->message->message_id ?? null;

        if (is_null($this->message_id)) {
            return "Только для запросов бота";
        }

        $this->updated_message_id = $update->callback_query->message->message_id ?? null;

        $this->setTelegramUser($update->message->from ?? $update->callback_query->from);

        $this->query = $update->message->text ?? $update->callback_query->data ?? '';

        $this->stopWebDialog();
        $this->startWebDialog('web_dialog');
        if (isset($update->message->photo))
            $this->photoUploaderHandler($update->message->photo);

        if ($this->maintenanceHanlder())
            return;

        $this->createNewBotUser();

        if (is_null($this->query))
            return;

        if ($this->conversationHandler()) {

            $webResult = $this->getForWebAll();
            $this->stopWebDialog();
            return [
                "message" => "success",
                "driver" => "web",
                "result" => $webResult,
                "status" => 200
            ];
        }

        $this->routeHandler();

        $webResult = $this->getForWebAll();
        $this->stopWebDialog();
        return [
            "message" => "success",
            "driver" => "web",
            "result" => $webResult,
            "status" => 200
        ];

    }

    private function inlineQueryHandler($query)
    {
        $messageId = $query->id;

        $this->setTelegramUser($query->from);

        $users =
            BotUserInfo::where("is_admin", true)
                ->where("is_working", true)
                ->orderBy("id", "DESC")
                ->take(8)
                ->skip(0)
                ->get();
        $button_list = [];

        $this->reply("Ищем активных администраторов....");
     /*   if (count($users) > 0) {
            foreach ($users as $user) {

                $tmp_user_id = (string)$user->chat_id;
                while (strlen($tmp_user_id) < 10)
                    $tmp_user_id = "0" . $tmp_user_id;

                $code = base64_encode("001" . $tmp_user_id);
                $url_link = "https://t.me/" . env("APP_BOT_NAME") . "?start=$code";

                $tmp_button = [
                    'type' => 'article',
                    'id' => uniqid(),
                    'title' => "Запрос к Администратору",
                    'input_message_content' => [
                        'message_text' => sprintf("Администратор #%s %s (%s)", $user->id, ($user->fio ?? $user->account_name ?? $user->chat_id), ($user->phone ?? 'Без телефона')),
                    ],
                    'reply_markup' => [
                        'inline_keyboard' => [
                            [
                                ['text' => "\xF0\x9F\x91\x89Послать запрос Администратору", "url" => "$url_link"],
                            ],

                        ]
                    ],
                    'thumb_url' => "https://sun2.48276.userapi.com/c848536/v848536665/177130/tzf1fK-6aio.jpg",
                    'url' => env("APP_URL"),
                    'description' => sprintf("Администратор #%s %s (%s)", $user->id, ($user->fio ?? $user->account_name ?? $user->chat_id), ($user->phone ?? 'Без телефона')),
                    'hide_url' => true
                ];

                array_push($button_list, $tmp_button);
            }
            $this->sendAnswerInlineQuery($messageId, $button_list);
        } else*/
            $this->reply("К сожалению активных администраторов не найдено...");

        return;
    }

    private function photoUploaderHandler($photos)
    {

        if (!$this->isConversationActive()) {
            $this->sendMessage("В данный момент загрузить фотографии нет возможности!");
            return;
        }

        foreach ($photos as $photo) {
            $file_id = $photo->file_id;

            $response = Http::get(sprintf("https://api.telegram.org/bot%s/getFile?file_id=%s",
                config("app.debug") ?
                    env("TELEGRAM_DEBUG_BOT") :
                    env("TELEGRAM_PRODUCTION_BOT"),
                $file_id
            ));

            $images = json_decode($this->storeGet("images", "[]"), true);
            //todo: fix this for many bots
            $path = sprintf("https://api.telegram.org/file/bot%s/%s",
                config("app.debug") ?
                    env("TELEGRAM_DEBUG_BOT") :
                    env("TELEGRAM_PRODUCTION_BOT"),
                $response->json()["result"]["file_path"]
            );


            array_push($images, $path);

            $this->setParams([
                "images" => json_encode($images)
            ]);
        }
        $this->sendMessage("Фотографии успешно загружены!");
        return;
    }

    private function maintenanceHanlder()
    {
        if (!env("APP_MAINTENANCE_MODE"))
            return false;

        $keyboard = [
            [
                ["text" => "Перейти в канал", "url" => "https://t.me/" . env("LMA_CHANNEL_LINK")]
            ]
        ];
        $this->sendPhoto("",
            "https://sun9-16.userapi.com/c858232/v858232349/173635/lTlP7wMcZEA.jpg", $keyboard);
        $this->sendMenu("Сервер находится на техническом обслуживании!", $this->keyboard_fallback_3);
        return true;
    }

    private function routeHandler()
    {
        $find = false;

        $matches = [];
        $arguments = [];

        $maxErrorIteration = count($this->list);

        foreach ($this->list as $item) {

            if ($maxErrorIteration === 0)
                break;

            $maxErrorIteration--;

            if (is_null($item["path"]))
                continue;

            if (preg_match($item["path"] . "$/i", $this->query, $matches) != false) {
                foreach ($matches as $match)
                    array_push($arguments, $match);

                try {

                    $item["function"]($this, ... $arguments);

                    $find = true;


                } catch (\Exception $e) {
                    Log::error($e->getMessage() . " " . $e->getLine());
                }

                break;
            }
        }


        if (!$find) {
            foreach ($this->list as $item) {
                if (!is_null($item["path"]))
                    continue;

                try {

                    $item["function"]($this);
                } catch (\Exception $e) {
                    Log::error($e->getMessage() . " " . $e->getLine());
                    $this->sendMenu("Произошла ошибка!", $this->keyboard_fallback_3);
                }

            }

        }
    }

    private function conversationHandler()
    {
        if (!$this->isConversationActive())
            return;

        $matches = [];

        $object = $this->currentActiveConversation();
        $is_conversation_find = false;

        if (!is_null($this->contact))
            $this->setParams([
                "phone" => $this->contact
            ]);

        foreach ($this->current_ask as $item) {
            if (is_null($item["name"]))
                break;

            $needValidate = !is_null($item["pattern"]);

            Log::info($needValidate ? "need" : "not need");
            $pattern = $needValidate ? preg_match($item["pattern"], $this->query, $matches) : null;

            $is_valid = $pattern != null;

            $message = $this->contact ?? $this->query;

            if ($item["name"] == $object->name) {
                $go_next = true;
                $is_active_fallback = false;
                if ($needValidate && !$is_valid && $item["fallback"] != null) {
                    $item["fallback"]($this, $message, $item["error_message"] ?? null);
                    $is_active_fallback = true;
                }

                if (!$is_active_fallback)
                    $go_next = is_null($item["pattern"]) && !is_null($item["fallback"]) ?
                        !$item["fallback"]($this, $message, $item["error_message"] ?? null) :
                        !Conversation::fallback($this, $message);

                if ($go_next)
                    if ($needValidate && $is_valid || !$needValidate)
                        $item["func"]($this, $message);


                $hide = $item["hide"];
                if ($hide)
                    $this->editReplyKeyboard();
                $is_conversation_find = true;
            }
        }

        if ($is_conversation_find)
            return true;


        if (!$is_conversation_find)
            $this->stopConversation();

        return false;
    }

    public function getUser(array $params = [])
    {
        return (count($params) == 0 ?
                BotUserInfo::where("chat_id", $this->telegram_user->id)->first() :
                BotUserInfo::with($params)->where("chat_id", $this->telegram_user->id)->first()) ?? null;

    }

    public function getChatId()
    {
        return $this->telegram_user->id;
    }

    public function sendMenu($message, $keyboard)
    {
        if (is_null($this->bot))
            return;
        try {

            $message = [
                "chat_id" => $this->telegram_user->id,
                "text" => $message,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode([
                    'keyboard' => $keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                ])
            ];

            $this->setForWeb([
                "result" => $message
            ]);

            $this->bot->sendMessage($message);

        } catch (\Exception $e) {
            Log::info(sprintf("%s %s %s",
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));
        }
    }

    public function createNewBotUser($parent_id = null)
    {
        $id = $this->telegram_user->id;
        $username = $this->telegram_user->username;
        $lastName = $this->telegram_user->last_name;
        $firstName = $this->telegram_user->first_name;

        if ($id == null)
            return false;

        if ($this->getUser() == null) {
            $user = User::create([
                'name' => $username ?? "$id",
                'email' => "$id@t.me",
                'phone' => "",
                'password' => bcrypt($id),
            ]);

            BotUserInfo::create([
                'chat_id' => $id,
                'account_name' => $username,
                'fio' => "$firstName $lastName",
                'cash_back' => 0,
                'phone' => null,
                'is_vip' => false,
                'is_admin' => false,
                'is_developer' => false,
                'is_working' => false,
                'parent_id' => $parent_id,
                'user_id' => $user->id
            ]);

            return true;
        }
        return false;
    }

    public function sendMessageToChat($chatId, $message, $keyboard = [], $parseMode = 'Markdown')
    {

        if (is_null($this->bot))
            return;
        try {

            $message = [
                "chat_id" => $chatId,
                "text" => $message,
                'parse_mode' => $parseMode,
                'reply_markup' => json_encode([
                    'inline_keyboard' => $keyboard
                ])
            ];

            $this->setForWeb([
                "result" => $message
            ]);

            $this->bot->sendMessage($message);


        } catch (\Exception $e) {
            Log::info(sprintf("%s %s %s",
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));
        }

    }

    public function sendMessage($message, $keyboard = [], $parseMode = 'Markdown')
    {

        if (is_null($this->bot))
            return;

        try {
            $message = [
                "chat_id" => $this->telegram_user->id,
                "text" => $message,
                'parse_mode' => $parseMode,
                'reply_markup' => json_encode([
                    'inline_keyboard' => $keyboard
                ])
            ];

            $this->setForWeb([
                "result" => $message
            ]);

            $this->bot->sendMessage($message);


        } catch (\Exception $e) {
            Log::info(sprintf("%s %s %s",
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));
        }


    }

    public function sendAnswerInlineQuery($id, $result)
    {

        if (is_null($this->bot))
            return;

        try {
            $this->bot->answerInlineQuery([
                'cache_time' => 300,
                "inline_query_id" => $id,
                "results" => json_encode($result)
            ]);
        } catch (\Exception $e) {
            Log::info(sprintf("%s %s %s",
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));
        }

    }

    public function getMessageId()
    {
        return $this->message_id;
    }

    public function deleteMessage($id = null)
    {
        if (is_null($this->bot))
            return;

        try {
            $this->bot->deleteMessage([
                'chat_id' => $id ?? $this->getChatId(),
                "message_id" => $this->message_id
            ]);
        } catch (\Exception $e) {

        }
    }

    public function editMessageCaption($caption = "empty")
    {
        if (is_null($this->bot))
            return;

        try {
            $this->bot->editMessageCaption([
                'caption ' => $caption,
                'chat_id' => $this->getChatId(),
                "message_id" => $this->message_id
            ]);
        } catch (\Exception $e) {

        }
    }

    public function editMessageText($text = "empty")
    {
        if (is_null($this->bot) || is_null($this->updated_message_id))
            return;

        try {
            $this->bot->editMessageText([
                'text' => $text,
                'chat_id' => $this->getChatId(),
                'parse_mode' => 'Markdown',
                "message_id" => $this->updated_message_id ?? $this->message_id
            ]);
        } catch (\Exception $e) {
            Log::info("Ошибочка editMessageText");
        }
    }

    public function editReplyKeyboard($keyboard = [])
    {

        if (is_null($this->bot) || is_null($this->updated_message_id))
            return;

        try {
            $this->bot->editMessageReplyMarkup([
                'chat_id' => $this->getChatId(),
                "message_id" => $this->updated_message_id ?? $this->message_id,
                'reply_markup' => json_encode([
                    'inline_keyboard' => $keyboard,
                ])
            ]);
        } catch (\Exception $e) {
            Log::info("Ошибочка editReplyKeyboard");
        }

    }

    public function sendQuiz($question, $options, $correct_option_id, $chatId = null, $keyboard = [], $parseMode = 'Markdown')
    {
        if (is_null($this->bot))
            return;

        $this->bot->sendPoll([
            'chat_id' => is_null($chatId) ? $this->telegram_user->id : $chatId,
            'parse_mode' => $parseMode,
            'question' => $question,
            'options' => $options,
            'is_anonymous' => false,
            'type' => "quiz",
            'correct_option_id' => $correct_option_id,
            'allows_multiple_answers' => false,
            'disable_notification' => 'true',
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard
            ])
        ]);
    }

    public function sendPoll($question, $options, $is_anonymous = ture, $allows_multiple_answers = false, $chatId = null, $keyboard = [], $parseMode = 'Markdown')
    {
        if (is_null($this->bot))
            return;


        $this->bot->sendPoll([
            'chat_id' => is_null($chatId) ? $this->telegram_user->id : $chatId,
            'parse_mode' => $parseMode,
            'question' => $question,
            'options' => $options,
            'is_anonymous' => $is_anonymous,
            'allows_multiple_answers' => $allows_multiple_answers,
            'disable_notification' => 'true',
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard
            ])
        ]);

    }

    public function sendPhoto($message, $photoUrl, $keyboard = [], $parseMode = 'Markdown')
    {
        if (is_null($this->bot))
            return;

        try {

            $message = [
                'chat_id' => $this->telegram_user->id,
                'parse_mode' => $parseMode,
                'caption' => $message,
                'photo' => InputFile::create($photoUrl),
                'disable_notification' => 'true',
                'reply_markup' => json_encode([
                        'inline_keyboard' => $keyboard
                    ]
                )
            ];
            $this->setForWeb([
                "result" => $message
            ]);


            $this->bot->sendPhoto($message);

        } catch (\Exception $e) {
            $tmp = mb_strlen($message) === 0 ? "Нет текста!" : $message;
            $this->sendMessage($tmp, $keyboard, $parseMode);
            //$this->sendPhoto($tmp, env("APP_URL") . "/img/noimage.jpg", $keyboard, $parseMode);
        }
    }

    public function sendMediaGroup($images, $type = "photo", $captions = null)
    {
        if (is_null($this->bot))
            return;

        $media = [];

        foreach (json_decode($images) as $key => $img) {
            array_push($media, ['media' => "$img", "type" => $type]);
            if (!is_null($captions)) {
                $media[$key]["caption"] = $captions[$key];
            }
        }


        try {
            Http::post(sprintf("https://api.telegram.org/bot%s/sendMediaGroup?chat_id=%s",
                (env('APP_DEBUG') ?
                    env("TELEGRAM_DEBUG_BOT") :
                    env("TELEGRAM_PRODUCTION_BOT")),
                $this->getChatId()
            ), [
                "media" => json_encode($media)
            ]);
        } catch (\Exception $e) {
            $this->reply("Хм, ошибка!");
        }
    }

    public function sendMediaGroupWithCaption($images)
    {
        if (is_null($this->bot))
            return;


        try {
            Http::post(sprintf("https://api.telegram.org/bot%s/sendMediaGroup?chat_id=%s",
                (env('APP_DEBUG') ?
                    env("TELEGRAM_DEBUG_BOT") :
                    env("TELEGRAM_PRODUCTION_BOT")),
                $this->getChatId()
            ), [
                "media" => json_encode($images)
            ]);
        } catch (\Exception $e) {
            $this->reply("Хм, ошибка!");
        }
    }

    public function sendAction($action = 'typing')
    {
        if (is_null($this->bot))
            return;

        $this->bot->sendChatAction([
            'chat_id' => $this->telegram_user->id,
            'action' => $action,
        ]);
    }

    public function sendLocation($latitude, $longitude, array $keyboard = [])
    {
        // TODO: Implement sendLocation() method.
    }

}
