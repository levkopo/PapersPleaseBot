<?php

class Passport
{
    public $ps_id;
    public $sex;
    public $male = false;
    public $country;
    public $city;

    public function __construct(){
        $this->ps_id = rand(10, 99)." ". rand(10, 99)." ".rand(10000, 999999);
        $country = array("Российская Федерация", "Украина", "Беларусь", "Казахстан", "Польша", "Литва", "Латвия", "Эстония", "Болгария");
        $country_index = rand(0,sizeof($country) - 1);
        $this->country = $country[$country_index];
        if(rand(0,100) <= 50){
            $this->sex = "Мужской";
            $this->male = true;
        }else{
            $this->sex = "Женский";
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
            'sex'=>$this->sex,
            'male'=>$this->male,
            'country'=>$this->country,
            'city'=>$this->city,
        );

        file_put_contents(__DIR__."/data/passports.json", json_encode($passports));
    }

    public function getPassportByUserId($user_id){
        $passports = json_decode(file_get_contents(__DIR__."/data/passports.json"));
        foreach ($passports->data as $passport){
            if($passport->user_id==$user_id){
                $this->ps_id = $passport->ps_id;
                $this->sex = $passport->sex;
                $this->male = $passport->male;
                $this->country = $passport->country;
                $this->city = $passport->city;
                return $this;
            }
        }

        return new Passport();
    }
}