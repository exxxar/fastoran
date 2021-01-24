<?php


namespace App\Classes\TGBot;



use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use ReflectionMethod;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Update;

class BaseBot extends AbstractBot implements iBaseBot
{


    public function __construct($token=nul,$botId=null)
    {
        $this->initBot($token,$botId);
    }

    public function reply($message, $keyboard = [], $parseMode = 'Markdown')
    {
        $this->sendMessage($message, $keyboard, $parseMode);
    }


    public function pagination($command, $model, $page, $resultMessage)
    {
        $inline_keyboard = [];

        if ($page == 0 && count($model) == env("PAGINATION_PER_PAGE"))
            array_push($inline_keyboard, ['text' => "Дальше", 'callback_data' => "$command " . ($page + 1)]);
        if ($page > 0) {
            if (count($model) == 0) {
                array_push($inline_keyboard, ['text' => "Назад", 'callback_data' => "$command " . ($page - 1)]);
            }
            if (count($model) == config("bot.results_per_page")) {
                array_push($inline_keyboard, ['text' => "Назад", 'callback_data' => "$command " . ($page - 1)]);
                array_push($inline_keyboard, ['text' => "Дальше", 'callback_data' => "$command " . ($page + 1)]);
            }
            if (count($model) > 0 && count($model) < env("PAGINATION_PER_PAGE")) {
                array_push($inline_keyboard, ['text' => "Назад", 'callback_data' => "$command " . ($page - 1)]);
            }
        }

        if (count($inline_keyboard) > 0)
            $this->sendMessage($resultMessage, [$inline_keyboard]);

    }


}
