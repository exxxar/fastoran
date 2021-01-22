<?php


namespace App\Conversations;


class Conversation
{

    public static function fallback($bot, $message, $error = null)
    {
        if ($message === "Продолжить позже") {
            $bot->getMainMenu("Хорошо! Продолжим позже!");
            $bot->stopConversation();
            return true;
        } else {
            if (!is_null($error))
                $bot->sendMessage(sprintf($error, $message));
            return false;
        }

    }


}
