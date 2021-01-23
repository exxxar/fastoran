<?php


namespace App\Conversations;


class Conversation
{

    public static function fallback($bot, $message, $error = null)
    {
        if ($message === "Продолжить позже") {
            if ($bot->getUser()->isActive())
                $bot->getMainMenu("Хорошо! Продолжим позже!");
            else
                $bot->getFallbackMenu2("Хорошо! Продолжим позже!");
            $bot->stopConversation();
            return true;
        } else {
            if (!is_null($error))
                $bot->sendMessage(sprintf($error, $message));
            return false;
        }

    }


}
