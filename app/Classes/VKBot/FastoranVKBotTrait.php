<?php


namespace App\Classes\VKBot;


use App\HUBRequest;
use App\OrderHubRule;
use Illuminate\Support\Facades\Log;

trait FastoranVKBotTrait
{
    use VKActions;

    protected $chatId;
    protected $vkUserId;
    protected $textCommand;
    protected $payloadCommand;

    public function handler()
    {

        if ($this->isBlocked()) {
            $this->sendMessage("Вам ограничена возможность делать запросы...");
            return;
        }

        $pattern = "/([a-zA-Z]+_[a-zA-Z]+).([0-9]{1,14})/";
        preg_match_all($pattern, $this->payloadCommand, $matches);


        $tmp_command = count($matches[1]) > 0 ?
            $matches[1][0] :
            ($this->payloadCommand ?? null);

        $tmp_vk_user_id = count($matches[2]) > 0 ? $matches[2][0] : null;

        $command = $tmp_command ?? $this->textCommand;

        $is_action_request = false;
        //not need auth
        switch ($command) {
            case "identification_channel":
                $this->requestIdentificationChannelAction();
                $is_action_request = true;
                break;
            case "identification_delivery":
                $this->requestIdentificationDeliverymanAction();
                $is_action_request = true;
                break;
            case "identification_admin":
                $this->requestIdentificationAdminAction();
                $is_action_request = true;
                break;
            case "debug_message":
                $this->requestDebugAction();
                break;
            default:
                $this->defaultAction();
                break;
        }

        if (!$this->isChannelInBase()) {
            $this->getBaseKeyboard($is_action_request ?
                "Спасибо! Ожидайте подтверждения!" :
                "Ваш канал еще не подтвержден");
            return;
        }


        if (!$this->isExistInBase()) {
            $this->getBaseKeyboard($is_action_request ?
                "Спасибо! Ожидайте подтверждения!" :
                "Вы еще не добавлены как администратор или доставщик! Обратитесь к администратору системы!");
            return;
        }

        if (!$this->isExistInChannel()) {
            $this->getBaseKeyboard($is_action_request ?
                "Спасибо! Ожидайте подтверждения!" :
                "Вы не являетесь ни администратором ни доставщиком для данного канала!");
            return;
        }

        $this->getMainKeyboard("Спасибо что работаете с нами!");

        //need auth
        switch ($command) {
            case "request_update_products":
                $this->requestUpdateProductsAction();
                break;
            case "decline_order":
                break;
            case "accept_order":
                break;
            case "accept_channel":
                break;
            case "accept_deliveryman":
                break;
            case "accept_admin":
                break;
            case "decline_admin":
                break;
            case "decline_deliveryman":
                break;

            default:
                $this->defaultAction();
                break;
        }
    }


    public function acceptDeliverymanAction()
    {

    }

    public function requestDebugAction()
    {
        $this->getDebugMessage();
    }

    public function requestUpdateProductsAction()
    {
        $this->sendMessage("Запрос на обновление продуктов");
    }

    protected function checkLatestRequests(){
        $in_request = HUBRequest::where("vk_user_id",$this->vkUserId)
            ->where("is_declined",false)
            ->where("is_confirmed", false)
            ->first();

        if (!is_null($in_request)){
            $this->sendMessage("Вы уже отправляли ранее запрос!");
            return true;
        }

        HUBRequest::create([
            'vk_user_id'=>$this->vkUserId,
            'vk_channel_id'=>$this->chatId,
            'comment'=>"",
            'request_type'=>0,
        ]);
        return false;
    }
    public function requestIdentificationChannelAction()
    {
        if ($this->checkLatestRequests())
            return;

        $this->sendMessage("Запрос на права доставщика");
        $this->sendMessageToChat(
            env("VK_FASTORAN_MAIN_ADMIN_CHANNEL"),
            "Новый запрос Активации канала"
        );
    }

    public function requestIdentificationDeliverymanAction()
    {
        if ($this->checkLatestRequests())
            return;

        $this->sendMessage("Запрос на права доставщика");
        $this->sendMessageToChat(
            env("VK_FASTORAN_MAIN_ADMIN_CHANNEL"),
            "Новый запрос на позицию Доставщика"
        );
       /*
        $this->sendRequestDeliverymanKB(sprintf("Запрос на право стать доставщиком\nRoom: %s\nUser: https://vk.com/id%s\n",
            $this->chatId,
            $this->vkUserId
        ),  $this->vkUserId );*/
    }

    public function requestIdentificationAdminAction()
    {
        if ($this->checkLatestRequests())
            return;

        $this->sendMessage("Запрос на права администратора");
        $this->sendMessageToChat(
            env("VK_FASTORAN_MAIN_ADMIN_CHANNEL"),
            "Новый запрос на позицию Администратора"
        );
    }

    public function defaultAction()
    {
        $this->sendMessage("Ошибка запроса!");
    }

    public function isBlocked()
    {
        $tmp = HUBRequest::where("vk_user_id", $this->vkUserId)->first();
        return is_null($tmp) ? false : $tmp->is_declined;
    }

    public function isChannelInBase()
    {
        return OrderHubRule::where("rest_channel_id", $this->chatId)
                ->orWhere("admin_channel_id", $this->chatId)
                ->orWhere("delivery_channel_id", $this->chatId)
                ->count() > 0;
    }

    public function isExistInBase()
    {
        return OrderHubRule::where("vk_user_id", $this->vkUserId)->count() > 0;
    }

    public function isExistInChannel()
    {
        return OrderHubRule::where("vk_user_id", $this->vkUserId)
                ->where("rest_channel_id", $this->chatId)
                ->first() != null;
    }

    public function isMainAdmin()
    {
        $tmp = OrderHubRule::where("vk_user_id", $this->vkUserId)
            ->where("rest_channel_id", $this->chatId)
            ->first();

        return is_null($tmp) ? false : $tmp->is_main_admin;
    }

    public function isLocalAdmin()
    {
        $tmp = OrderHubRule::where("vk_user_id", $this->vkUserId)
            ->where("rest_channel_id", $this->chatId)
            ->first();

        return is_null($tmp) ? false : $tmp->is_admin;
    }

    public function isDeliveryman()
    {
        $tmp = OrderHubRule::where("vk_user_id", $this->vkUserId)
            ->where("rest_channel_id", $this->chatId)
            ->first();

        return is_null($tmp) ? false : $tmp->is_deliveryman;
    }


    public function getMainKeyboard($message)
    {
        $this->sendMainKB($message);
    }


    public function getBaseKeyboard($message)
    {
        $this->sendBaseKB($message);
    }

    public function getDebugMessage()
    {
        $this->sendMessage(sprintf("Ваш chadId: %s\nВаш vkId: %s\nТекст: %s\nКоманда: %s\n",
            $this->chatId,
            $this->vkUserId,
            $this->textCommand,
            ($this->payloadCommand ?? "Отсутствует")
        ));
    }

}
