<?php

header("Content-type: image/png");
$im     = imagecreatefrompng("paper.png");
$def_color = imagecolorallocate($im, 0x71, 0x71, 0x71);
$gray_color = imagecolorallocate($im, 0x99, 0x99, 0x99);
$red_color = imagecolorallocate($im, 0xC6, 0x00, 0x00);

$first_name = $_GET['first_name'];

$last_name = $_GET['last_name'];

$passport_id = $_GET['passport_id'];

$city = $_GET['city'];

$birthday = $_GET['birthday'];

$country_index = $_GET['country_index'];
$country = array("Российская Федерация", "Украина", "Беларусь", "Казахстан", "Польша", "Литва", "Латвия", "Эстония", "Болгария")[$country_index];

$passport_exp = $_GET['passport_exp'];

$sex_id = $_GET['sex_id'];
$sex = $sex_id==1 ? "Мужской" : "Женский";

imagettftext ($im, 45, 0, 155,1025+70, $def_color, './font.ttf', $last_name.", ".$first_name);
imagettftext ($im, 45, 0, 150,1700+70, $red_color, './font.ttf', $passport_id);
imagettftext ($im, 45, 0, 785,1590+60, 1590, './font.ttf', $country);
imagettftext ($im, 40, 0, 580,1390+70, $gray_color, './font.ttf', $city);
imagettftext ($im, 40, 0, 955,1135+60, $gray_color, './font.ttf', $birthday);
imagettftext ($im, 40, 0, 710,1220+60, $gray_color, './font.ttf',  $sex);
imagettftext ($im, 40, 0, 810,1485+60, $gray_color, './font.ttf', $passport_exp);
imagepng($im);
imagedestroy($im);
