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
            switch(rand(0,8)){
                case 0:
                    $country = "Российская Федерация";
                    break;
                case 1:
                    $country = "Украина";
                    break;
                case 2:
                    $country = "Беларусь";
                    break;
                case 3:
                    $country = "Казахстан";
                    break;
                case 4:
                    $country = "Польша";
                    break;
                case 5:
                    $country = "Литва";
                    break;
                case 6:
                    $country = "Латвия";
                    break;
                case 7:
                    $country = "Эстония";
                    break;
                case 8:
                    $country = "Болгария";
                    break;
            }
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