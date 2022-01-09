<?php

ob_start();
$API_KEY = '5021622888:AAGPxgHt9o8yNRt94NXrvgXmgFAURhNsSPE';


$site = "https://api-quran.cf";

define("API_KEY",$API_KEY);

function bot($method,$str=[]){
        $http_build_query = http_build_query($str);
        $api = "https://api.telegram.org/bot".API_KEY."/".$method."?$http_build_query";
        $http_build_query = file_get_contents($api);
        echo file_get_contents("https://api.telegram.org/bot".API_KEY. "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);
        function bot($method,$webhook=[]){
        $webhook = http_build_query($webhook);
        $url = "https://api.telegram.org/bot".API_KEY."/".$method."?$webhook";
        $webhook = file_get_contents($url);
        return json_decode($webhook,$http_build_query);}
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

$sour = array("page001","page002");
//الباحث الصوتي

$sound = array(
  "عبد الباسط عبد الصمد",
  "عودة",
  );

$soundafter = array(
  "abdul_basit",
  "sddeq",
  );

$soundsave = str_replace($sound, $soundafter, $text);

//start
if($text == "/start" or $text == "عودة"){
  $json ["$id"]["save"] = "start";
  file_put_contents("save.txt",json_encode($json));
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"
حياك الله في خدمة الباحث القرآني

خدمة الباحث القرآني على الانترنت :
    ".$site,
    "reply_to_message_id"=>$message_id,
    "reply_markup"=>json_encode([
      'keyboard'=>[
          [['text'=>'الباحث الصوتي']],
        ],
        'resize_keyboard'=>true
    ]),
  ]);
  return;
}


//أوامر الباحث الصوتي


if($text == "الباحث الصوتي"){
  foreach($sound as $key){
    $keyboard[] = [$key];
  }
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"
حسنا ، اختر أحد القراء
    ",
    "reply_to_message_id"=>$message_id,
    "reply_markup"=>json_encode([
      'keyboard'=>$keyboard
    ])
  ]);
  return;
}

if(in_array($text,$sound)){
  $json ["$id"]["save"] = "$soundsave";
  file_put_contents("save.txt",json_encode($json));
  foreach($sour as $key){
    $keyboard[] = [$key];
  }
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"تم إختيار القارئ ، قم الآن بكتابة اسم السورة أو قم بالإختيار من الكيبورد في الاسفل..",
    "reply_to_message_id"=>$message_id,
    "reply_markup"=>json_encode([
      'keyboard'=>$keyboard
    ])
  ]);
  return;
}



if(in_array($save,$soundafter)){
  $get = json_decode(file_get_contents("http://telegramlibrary.aba.vg/index.php?soura=".urlencode($text)."&readernameEngilsh=".$save));
  if(isset($get->error)){
    bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>$get->error,
      "reply_to_message_id"=>$message_id,
  ]);
  return;
  }
  bot('sendMessage',[
    'chat_id' => $chat_id,
    'text' => $get,
    "reply_to_message_id"=>$message_id,
  ]);
  return;
}



if($message){
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"
لم أتمكن من فهم هذا الأمر ، يرجى إرسال

/start
    ",
    "reply_to_message_id"=>$message_id,
  ]);
}

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

?>
