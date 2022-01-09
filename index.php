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

$sour = array("عودة","الفاتحة","البقرة","آل عمران","النساء","المائدة","الأنعام","الأعراف","الأنفال","التوبة","يونس","هود","يوسف","الرعد","ابراهيم","الحجر","النحل","الإسراء","الكهف","مريم","طه","الأنبياء","الحج","المؤمنون","النور","الفرقان","الشعراء","النمل","القصص","العنكبوت","الروم","لقمان","السجدة","الأحزاب","سبإ","فاطر","يس","الصافات","ص","الزمر","غافر","فصلت","الشورى","الزخرف","الدخان","الجاثية","الأحقاف","محمد","الفتح","الحجرات","ق","الذاريات","الطور","النجم","القمر","الرحمن","الواقعة","الحديد","المجادلة","الحشر","الممتحنة","الصف","الجمعة","المنافقون","التغابن","الطلاق","التحريم","الملك","القلم","الحاقة","المعارج","نوح","الجن","المزمل","المدثر","القيامة","الانسان","المرسلات","النبإ","النازعات","عبس","التكوير","الإنفطار","المطففين","الإنشقاق","البروج","الطارق","الأعلى","الغاشية","الفجر","البلد","الشمس","الليل","الضحى","الشرح","التين","العلق","القدر","البينة","الزلزلة","العاديات","القارعة","التكاثر","العصر","الهمزة","الفيل","قريش","الماعون","الكوثر","الكافرون","النصر","المسد","الإخلاص","الفلق","الناس");

//الباحث النصي
$write = array(
  "ابحث عن آية",
  "تفسير آية - الميسر",
  "تفسير آية - الجلالين",
  "شرح آية باللغة الإنجليزية",
  "عودة",
  );
$writeafter = array(
  "search",
  "tafser2",
  "tafser1",
  "english"
  );
$writemessage = array(
  "حسنا ، أرسل ما تذكره من الآية ليتم البحث عنها",
  "حسنا ، أرسل ما تذكره من الآية ليتم تفسيرها -تفسير الميسر-",
  "حسنا ، أرسل ما تذكره من الآية ليتم تفسيرها -تفسير الجلالين-",
  "حسنا ، أرسل ما تذكره من الآية ليتم شرحها باللغة الإنجليزية",
  );
$writesave = str_replace($write, $writeafter, $text);
$writemessage = str_replace($write, $writemessage, $text);


//الباحث الصوتي

$sound = array(
  "عبد الباسط عبد الصمد",
  "عبد الله المطرود",
  "عبد الرحمن العوسي",
  "أبو بكر الشاطري",
  "أحمد العجمي",
  "فارس عباد",
  "محمود خليل الحصري",
  "ماهر المعيقلي",
  "محمد صديق المنشاوي",
  "عودة",
  );

$soundafter = array(
  "abdul_basit",
  "al_matrood",
  "al_ausi",
  "al_shatri",
  "al_ajmi",
  "abbad",
  "al_husori",
  "al_mueaqly",
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
          [['text'=>'الباحث النصي']],
          [['text'=>'الباحث الصوتي']],
        ],
        'resize_keyboard'=>true
    ]),
  ]);
  return;
}



//أوامر الباحث النصي
if($text == "الباحث النصي"){
  foreach($write as $key){
    $keyboard[] = [$key];
  }
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"
حسنا ، اختر أحد الأقسام

خدمة الباحث القرآني على الانترنت :
    ".$site,
    "reply_to_message_id"=>$message_id,
    "reply_markup"=>json_encode([
      'keyboard'=>$keyboard
    ])
  ]);
  return;
}


if(in_array($text,$write)){
  $json ["$id"]["save"] = "$writesave";
  file_put_contents("save.txt",json_encode($json));
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>$writemessage,
    "reply_to_message_id"=>$message_id,
  ]);
  return;
}

if(in_array($save,$writeafter)){
  $get = json_decode(file_get_contents("https://api-quran.cf/quransql/index.php?text=".urlencode($text)."&type=".$save))->result;
  $count = count($get);
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"تم العثور على $count من النتائج",
    "reply_to_message_id"=>$message_id,
  ]);
  if($count > 10)
    $l = 10;
  else
    $l = $count;
  for( $i=0; $i <= $l; $i++){
    bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>$get[$i],
    ]);
  }
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
  $get = json_decode(file_get_contents("https://api-quran.cf/quransql/mp3.php?text=".urlencode($text)."&reader=".$save));
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
    'audio' => $get->url,
    'caption'=>$get->caption,
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
