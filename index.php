<?php

ob_start();

$API_KEY = "5019776526:AAEiZiHrfvICr6vcoNfv40rkLzUXYXLqRsQ";
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

$sour = array("الوجه001","الوجه002","الوجه003","عودة");

// Search audio

$sound = array(
  "محمود الحصري",
  "عودة",
  );

$soundafter = array(
  "Al_husari",
  );

$soundsave = str_replace($sound, $soundafter, $text);

//start

if($text == "/start" or $text == "عودة"){
  $json ["$id"]["save"] = "start";
  file_put_contents("save.txt",json_encode($json));
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"Welcome to the quran pages search:
    ",
    "reply_to_message_id"=>$message_id,
    "reply_markup"=>json_encode([
      'keyboard'=>[
          [['text'=>'بحث عن صفحات القران']],
        ],
        'resize_keyboard'=>true
    ]),
  ]);
  return;
}



//Commands Search audio

if($text == "بحث عن صفحات القران"){
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
    "text"=>"تم إختيار القارئ ، قم الآن بكتابة الصوحة أو قم بالإختيار من الكيبورد في الاسفل.",
    "reply_to_message_id"=>$message_id,
    "reply_markup"=>json_encode([
      'keyboard'=>$keyboard
    ])
  ]);
  return;
}
/*
if($text){
  $get = json_decode(file_get_contents("http://api-abaquran.aba.vg/handler.php?text=$text&readernameEngilsh=Al_husari"));
  bot('sendaudio',[
    'chat_id' => $chat_id,
    'audio' => $get->audio,
    "reply_to_message_id"=>$message_id,
  ]);
}
*/

if(in_array($save,$soundafter)){
  $get = json_decode(file_get_contents("http://api-abaquran.aba.vg/handler.php?text=$text&readernameEngilsh=Al_husari"));
  if(isset($get->error)){
    bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>$get->error,
      "reply_to_message_id"=>$message_id,
  ]);
  return;
  }
  bot('sendaudio',[
    'chat_id' => $chat_id,
    'audio' => $get->audio,
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

?>
