<?php

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

$sour = array("الوجه001","الوجه002","الوجه003","الوجه004","الوجه005","الوجه006","الوجه007","الوجه008","الوجه009","الوجه010","الوجه011","الوجه012","الوجه013","الوجه014","الوجه015","الوجه016","الوجه017","الوجه018","الوجه019","الوجه020","الوجه021","الوجه022","الوجه023","الوجه024","الوجه025","الوجه026","الوجه027","الوجه028","الوجه029","الوجه030","الوجه021","الوجه042","الوجه043","الوجه044","الوجه045","الوجه046","الوجه047","الوجه048","الوجه049","الوجه050");

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

