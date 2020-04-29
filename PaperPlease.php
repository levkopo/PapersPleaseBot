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
        if(strcasecmp($data->text, "паспорт")){
            $this->func->sendMessage($data->peer_id, "---Паспорт---\n
            PS-ID:" (string)rand(0, 10) . (string)rand(10, 40) . (string)rand(100000, 999999));
        }
    }


    public function call($type, $data){}

    public function VKApp_call($data){}

    public function getInfo($data){}

    public function onNewAppMessage($data){}
}