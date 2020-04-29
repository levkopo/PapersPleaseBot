<?php

class Passport
{
    public $ps_id;
    public $sex;
    public $sex_id;
    public $country;
    public $country_index;
    public $city;

    public function __construct(){
        $this->ps_id = rand(10, 99)." ". rand(10, 99)." ".rand(10000, 999999);
        $country = array("Российская Федерация", "Украина", "Беларусь", "Казахстан", "Польша", "Литва", "Латвия", "Эстония", "Болгария");
        $this->country_index = rand(0,sizeof($country) - 1);
        $this->country = $country[$this->country_index];
        if(rand(0,100) <= 50){
            $this->sex = "Мужской";
            $this->sex_id = 1;
        }else{
            $this->sex = "Женский";
            $this->sex_id = 0;
        }
    }
    public function savePassport($user_id){
        $passports = json_decode(file_get_contents(__DIR__."/data/passports.json"));
        if(!isset($passports->data)){
            $passports->data = array();
        }

        $passports->data[] = array(
            'user_id'=>$user_id,
            'ps_id'=>$this->ps_id,
            'sex_id'=>$this->sex_id,
            'country_index'=>$this->country_index,
            'city'=>$this->city,
        );

        file_put_contents(__DIR__."/data/passports.json", json_encode($passports));
    }

    public static function deletePassport($user_id){
        $passports = json_decode(file_get_contents(__DIR__."/data/passports.json"));
        for($i = 0; $i < sizeof($passports->data); $i++){
            if($passports->data[$i]->user_id==$user_id){
                unset($passports->data[$i]);
            }
        }
        file_put_contents(__DIR__."/data/passports.json", json_encode($passports));
    }

    public function getPassportByUserId($user_id){
        $passports = json_decode(file_get_contents(__DIR__."/data/passports.json"));
        foreach ($passports->data as $passport){
            if($passport->user_id==$user_id){
                $this->ps_id = $passport->ps_id;
                $this->sex_id = $passport->sex_id;
                $this->country_index = $passport->country_index;
                $this->city = $passport->city;
                return $this;
            }
        }
        return false;
    }
}