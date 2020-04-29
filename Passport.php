<?php

class Passport
{
    public $ps_id;
    public $sex;
    public $male = false;
    public $country;
    public $city;

    private $passports;

    public function __construct(){
        $this->passports = json_decode(file_get_contents(__DIR__."/data/passports.json"));

        $this->ps_id = rand(12, 99)." ". rand(12, 99)." ".rand(123456, 999999);
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

        $this->passports->passports->{$user_id} = array(
            'ps_id'=>$this->ps_id,
            'sex'=>$this->sex,
            'male'=>$this->male,
            'country'=>$this->country,
            'city'=>$this->city,
        );

        file_put_contents(__DIR__."/data/passports.json", json_encode($this->passports));
    }

    public function getPassportByUserId($user_id){
        if(!isset($this->passports->passports->{$user_id}))
            return new Passport();

        $passport = $this->passports->passports->{$user_id};
        $this->ps_id = $passport->ps_id;
        $this->sex = $passport->sex;
        $this->male = $passport->male;
        $this->country = $passport->country;
        $this->city = $passport->city;

        return $this;
    }
}