<?php

require_once "Passport.php";
class PaperPlease implements Bot
{

    public $func;
    public $lang;
    private $admins = array(396368025, 432176401);

    public function __construct($func)
    {
        $this->func = $func;
        $this->lang = $func->getLang(__DIR__);
    }

    public function verify($secretKey){
        return "ab37EghD5gfE5fg54" == $secretKey;
    }

    public function onNewMessage($data, $client_info){

        //Трансформируем БОЛЬШИЕ БУКВЫ в маленькие
        $data->text = mb_strtolower($data->text, 'UTF-8');

        $words = explode(' ', $data->text);
        $payload = isset($data->payload) ? json_decode($data->payload) : false;

        if($words[0] == "помощь") {
            $this->func->sendMessage($data->peer_id, $this->lang['help']);
            return;
        }

        if($words[0] == "-del" && in_array($data->from_id, $this->admins)){
            Passport::deletePassport($data->from_id);
            $this->func->sendMessage($data->peer_id, "Игра удалена");
            return;
        }

        if($words[0] == "начать"&&isset($words[1])&&$words[1]=="игру"||$payload&&$payload->command=="-newGame") {
            $this->newGame($data);
            return;
        }

        if($words[0] == "да"&&isset($words[1])&&$words[1]=="игру"||$payload&&$payload->command=="-yes") {
            $this->verifyAnswer($data,true);
            return;
        }

        if($words[0] == "нет"&&isset($words[1])&&$words[1]=="игру"||$payload&&$payload->command=="-no") {
            $this->verifyAnswer($data,false);
            return;
        }

        $this->getInfo($data);
    }

    public function newGame($data){
        $passport = new Passport();
        if($passport->getPassportByUserId($data->from_id)){
            $this->func->sendMessage($data->peer_id, "Игра уже запущена!");
            return;
        }
        $passport->savePassport($data->from_id);
        $passport_name = __DIR__ . '/images/tmp' . rand(0, 1000) . '.png';
        $tmp_params = http_build_query(array(
            'country_index'=>$passport->country_index,
            'sex_id'=>$passport->sex_id,
            'passport_id'=>$passport->ps_id,
        ));
        $tmp_image = file_get_contents('https://levkopo.fvds.ru/nBotM/bots/194781513/images/paper_image.php?'.$tmp_params);
        file_put_contents($passport_name, $tmp_image);

        $attachment_ = $this->func->uploadPhoto($data->peer_id, $passport_name)->response[0];
        $attachment = "photo" . $attachment_->owner_id . "_" . $attachment_->id;
        unlink($passport_name);

        $this->func->keyboard['buttons'][0] = array(
            array(
                "action"=>array(
                    "type"=>"text",
                    "label"=>"Да",
                    "payload"=>"{\"command\":\"-yes\"}"
                ),
                "color" =>"positive"
            ),
            array(
                "action"=>array(
                    "type"=>"text",
                    "label"=>"Нет",
                    "payload"=>"{\"command\":\"-no\"}"
                ),
                "color" =>"negative"
            ),
        );
        $this->func->sendMessage($data->peer_id, "", $attachment);
    }

    public function verifyAnswer($data, $answer){
        $this->func->sendMessage($data->peer_id, "Наверное вы правы)");
        Passport::deletePassport($data->from_id);
        $this->newGame($data);
    }

    public function call($type, $data){}

    public function VKApp_call($data){}

    public function getInfo($data){
        $passport = new Passport();
        if(!$passport->getPassportByUserId($data->from_id))
            $this->func->keyboard['buttons'][0][] =
                array(
                    "action"=>array(
                        "type"=>"text",
                        "label"=>"Начать игру",
                        "payload"=>"{\"command\":\"-newGame\"}"
                    ),
                    "color" =>"positive"
                );

        $this->func->sendMessage($data->peer_id, $this->lang['help']);
    }

    public function onNewAppMessage($data){}
}