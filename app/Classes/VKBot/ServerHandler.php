<?php


namespace App\Classes\VKBot;


use ATehnix\LaravelVkRequester\Models\VkRequest;
use Illuminate\Support\Facades\Log;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;
use VK\Client\VKApiClient;

class ServerHandler extends VKCallbackApiServerHandler
{
    use FastoranVKBotTrait;

    const IS_DEBUG_MODE = true;

    const SECRET = 'fastoran_bot_secret_1';
    const GROUP_ID = 129163510;
    const CONFIRMATION_TOKEN = 'aa3d2774';

    function confirmation(int $group_id, ?string $secret)
    {
        if ($secret === static::SECRET && $group_id === static::GROUP_ID) {
            echo static::CONFIRMATION_TOKEN;
        }
    }

    public function messageNew(int $group_id, ?string $secret, array $object)
    {
        Log::info(print_r($object, true));

        $this->chatId = $object["peer_id"] ?? $object['user_id'];
        $this->vkUserId = $object["from_id"] ?? $object['user_id'];
        $this->textCommand = $object["text"];
        $this->payloadCommand = isset($object["payload"]) ? json_decode($object["payload"])->button : null;

        $this->handler();

        /*   $this->getMainKeyboard(
               "Главное меню"
           );

           $this->sendInlineKB(
               "Поехать кукухой? " . ($object["from_id"] ?? "Непонятно от кого"),
               [
                   [
                       [
                           "action" => [
                               "type" => "text",
                               "payload" => "{\"button\":\"1\"}",
                               "label" => "Да, поехать!"
                           ],
                           "color" => "negative"
                       ],
                       [
                           "action" => [
                               "type" => "text",
                               "payload" => "{\"button\":\"2\"}",
                               "label" => "Нет, поехать!"
                           ],
                           "color" => "primary"
                       ]
                   ]
               ]
           );*/

        echo 'ok';

    }
}
