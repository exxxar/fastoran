<?php

namespace App\Http\Controllers;

use App\Bot;


use App\Classes\TGBot\BaseBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{
    private $bot;

    public function handle(Request $request, $name)
    {
        $tmp_result = "success";
        try {
            Log::info("start with name = $name");
            $local_bot = Bot::where("bot_url", $name)->first();
            $this->bot = new BaseBot(env("APP_DEBUG") ?
                $local_bot->token_dev :
                $local_bot->token_prod, $local_bot->id);
            $updates = $this->bot->getWebhookUpdates();
            $tmp_result = $this->bot->handler($updates);
        } catch (\Exception $e) {
            $error_message = sprintf("%s %s %s",
                $e->getFile(),
                $e->getLine(),
                $e->getMessage()
            );

            Log::info($error_message);

            return response()->json([
                "message" => $error_message
            ]);
        }
        return response()->json($tmp_result);

    }
}
