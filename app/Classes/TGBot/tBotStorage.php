<?php


namespace App\Classes\TGBot;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait tBotStorage
{

    public function clearStorage($prefix = null)
    {
        Cache::forget((is_null($prefix) ? '' : $prefix) . $this->getChatId());
    }

    public function addToStorage($key, $value, $prefix = null)
    {
        $tmp_id = (is_null($prefix) ? '' : $prefix) . $this->getChatId();
        $tmp = json_decode(Cache::get($tmp_id, "[]"), true);
        $tmp[$key] = $value;
        Cache::forget($tmp_id);
        Cache::add($tmp_id, json_encode($tmp));

    }

    public function hasInStorage($key, $prefix = null)
    {
        $tmp_id = (is_null($prefix) ? '' : $prefix) . $this->getChatId();
        $tmp = json_decode(Cache::get($tmp_id, "[]"), true);

        return array_key_exists($key, $tmp);
    }

    public function getFromStorage($key, $default = null, $prefix = null)
    {
        $tmp_id = (is_null($prefix) ? '' : $prefix) . $this->getChatId();
        $tmp = json_decode(Cache::get($tmp_id, "[]"), true);
        return count($tmp) > 0 ? $tmp[$key] : $default;
    }
}
