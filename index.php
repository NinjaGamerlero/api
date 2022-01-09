<?php

/*  
    * ملف بوت الباحث القرآني
    * الإصدار الرابع
    * الجديد  :
    تم إضافة باحث صوتي 
    ل 9 من القراء
    
    تمت برمجة هذه المشروع 
    من قبل فريق
    @api_tele
*/

ob_start();

$API_KEY = "5021622888:AAGPxgHt9o8yNRt94NXrvgXmgFAURhNsSPE"; //your token bot
$site = "https://api-quran.cf";

define("API_KEY",$API_KEY);
function bot($method,$str=[]){
        $http_build_query = http_build_query($str);
        $api = "https://api.telegram.org/bot".API_KEY."/".$method."?$http_build_query";
        $http_build_query = file_get_contents($api);
        return json_decode($http_build_query);
}

$update = json_decode(file_get_contents("php://input"));
$message = $update->message;
$id = $message->from->id;
$chat_id = $message->chat->id;
$text = $message->text;
$message_id = $message->message_id;

$ar = ['id' => '1','soura' => 'الوجه001','souraEnglish' => 'الفاتحة','audio' => 'https://t.me/c/1776737849/2','readername' => 'عبد الباسط عبد الصمد','readernameEngilsh' => 'abdul_basit','sort' => 'none'];

$ob = json_decode($ar);

$os = json_decode($ob);
if($text){
   bot('sendaudio',[
    'chat_id' => $chat_id,
    'audio' => "https://t.me/c/1776737849/2",
    "reply_to_message_id"=>$message_id,
   ]);
}
