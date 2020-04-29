<?php

class PaperPlease implements Bot
{

    public $func;
    public $lang;

    public function __construct($func)
    {
        $this->func = $func;
        $this->lang = $func->getLang(__DIR__);
    }

    public function verify($secretKey){
        return "ab37EghD5gfE5fg54" == $secretKey;
    }

    public function onNewMessage($data, $client_info){
        $peer_id = $data->peer_id;
        $this->func->sendMessage($peer_id, "Привет!");
    }


    public function call($type, $data){}

    public function VKApp_call($data){}

    public function getInfo($data){}

    public function onNewAppMessage($data){}
}