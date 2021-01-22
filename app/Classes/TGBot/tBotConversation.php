<?php


namespace App\Classes\TGBot;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait tBotConversation
{


    protected $last_method_id;

    public function currentActiveConversation()
    {
        return (object)json_decode($this->getFromStorage("is_conversation_active"));
    }

    public function storeGet($key, $default = '')
    {
        return json_decode($this->getFromStorage("is_conversation_active"), true)["params"][$key] ?? $default;
    }

    public function next($name, $params = [])
    {

        $tmp_params = json_decode($this->getFromStorage("is_conversation_active"), true)["params"] ?? [];

        foreach ($params as $key => $value) {
            $tmp_params[$key] = $value;
        }

        $this->addToStorage("is_conversation_active", json_encode([
            "name" => $name,
            "params" => $tmp_params
        ]));
    }

    public function setParams($params = [])
    {
        $tmp_params = json_decode($this->getFromStorage("is_conversation_active"), true)["params"] ?? [];
        $tmp_name = json_decode($this->getFromStorage("is_conversation_active"), true)["name"] ?? '';

        foreach ($params as $key => $value) {
            $tmp_params[$key] = $value;
        }
        $this->addToStorage("is_conversation_active", json_encode([
            "name" => $tmp_name,
            "params" => $tmp_params
        ]));
    }

    public function startConversation($name, $data = [])
    {
        $this->next($name, $data);
    }

    public function stopConversation()
    {
        $this->clearStorage();
    }

    public function isConversationActive()
    {
        return $this->hasInStorage("is_conversation_active");
    }


}
