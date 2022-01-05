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

$API_KEY = "5019776526:AAEiZiHrfvICr6vcoNfv40rkLzUXYXLqRsQ"; //your token bot

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

if($text){
$url = file_get_contents("http://api-abaquran.aba.vg/handler.php?soura=$text&readernameEngilsh=Al_husari");
   
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$url
]);

}

?>
