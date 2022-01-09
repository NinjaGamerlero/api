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

$json = json_decode(file_get_contents("save.txt"),true);
$getjson = json_decode(file_get_contents("save.txt"));

$user = $getjson->$id;
$save = $user->save;

if($text){
   $get = file_get_contents("http://telegramlibrary.aba.vg/index.php");
   bot('sendaudio',[
    'chat_id' => $chat_id,
    'audio' => $get->audio,
    "reply_to_message_id"=>$message_id,
   ]);
}

?>
