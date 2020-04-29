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
        if($data->text == "паспорт"){
            $country = array("Российская Федерация", "Украина", "Беларусь", "Казахстан", "Польша", "Литва", "Латвия", "Эстония", "Болгария");
            $country = $country[rand(0,sizeof($country-1))];

            if(rand(0,100) <= 50){
                $sex = "Мужской";
            }else $sex = "Женский";
            $this->func->sendMessage($data->peer_id, "---Паспорт---\n 
            PS-ID:".rand(0, 10) . " " . rand(10, 40). " " .rand(100000, 999999) . "\nПол: $sex\nСтарана: $country");
        }
    }


    public function call($type, $data){}

    public function VKApp_call($data){}

    public function getInfo($data){}

    public function onNewAppMessage($data){}
}