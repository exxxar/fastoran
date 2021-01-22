<?php


namespace App\Classes\TGBot;



use Illuminate\Support\Facades\Log;

trait tBotWebStorage
{

    public function getForWebAll()
    {
        return json_decode($this->getFromStorage("to_web",null,"web"), true)["params"] ?? [];
    }

    public function getForWeb($key, $default = '')
    {
        return json_decode($this->getFromStorage("to_web",null,"web"), true)["params"][$key] ?? $default;
    }

    public function setForWeb($params = [])
    {
        $tmp_params = json_decode($this->getFromStorage("to_web",null,"web"), true)["params"] ?? [];
        $tmp_name = json_decode($this->getFromStorage("to_web",null,"web"), true)["name"] ?? '';

       // Log::info("TMP_NAME".print_r($this->getFromStorage("to_web"), true));
        foreach ($params as $key => $value) {
            //$tmp_params[$key] = $value;
            array_push($tmp_params,$value);
        }


        $this->addToStorage("to_web", json_encode([
            "name" => $tmp_name,
            "params" => $tmp_params
        ]),"web");
    }


    public function startWebDialog($name='',$params = [])
    {
        $tmp_params = json_decode($this->getFromStorage("to_web",null,"web"), true)["params"] ?? [];


        foreach ($params as $key => $value) {
            $tmp_params[$key] = $value;
        }

        $this->addToStorage("to_web", json_encode([
            "name" => $name,
            "params" => $tmp_params
        ]),"web");

        Log::info("TMP_NAME".print_r($this->getFromStorage("to_web",null,"web"), true));
    }

    public function stopWebDialog()
    {

        $this->clearStorage("web");
    }


}
