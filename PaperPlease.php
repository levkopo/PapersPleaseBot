<?php

require_once "Passport.php";
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
        $words = explode(' ', $data->text);
        if($words[0] == "паспорт") {
            $passport = new Passport();
            $passport->savePassport($data->from_id);

            $passport_name = __DIR__ . '/images/tmp' . rand(0, 1000) . '.png';
            $tmp_params = http_build_query(array(
                'male'=>$passport->male,
                'passport_id'=>$passport->ps_id,
            ));
            $tmp_image = file_get_contents('https://levkopo.fvds.ru/nBotM/bots/194781513/images/paper_image.php?'.$tmp_params);
            file_put_contents($passport_name, $tmp_image);

            $attachment_ = $this->func->uploadPhoto($data->peer_id, $passport_name)->response[0];
            $attachment = "photo" . $attachment_->owner_id . "_" . $attachment_->id;
            unlink($passport_name);

            $this->func->sendMessage($data->peer_id, "Данные верны?", $attachment);
        }
    }
    public function call($type, $data){}

    public function VKApp_call($data){}

    public function getInfo($data){}

    public function onNewAppMessage($data){}
}