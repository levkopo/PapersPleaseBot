<?php

public class Passport
{
    public $sex, $sex_index, $county, $county_index, $city, $ps_id;
    public function generate(){
        $country = array("Российская Федерация", "Украина", "Беларусь", "Казахстан", "Польша", "Литва", "Латвия", "Эстония", "Болгария");
        $county_index = rand(0,sizeof($country) - 1);
        $country = $country[$county_index];
        if(rand(0,100) <= 50){
            $sex = "Мужской";
            $sex_index = 0;
        }else{
            $sex = "Женский";
            $sex_index = 1;
        }
    }
    public function getPassportByUserId($user_id){
        
    }
}