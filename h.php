<?php
function bot($method, $datas = []) {
$token = "1738349015:AAG73rvOdp0_vcg3QEGZ7MovmDEKMR7eHLc";//توكن
$url = "https://api.telegram.org/bot$token/" . $method;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$res = curl_exec($ch);
curl_close($ch);
return json_decode($res, true);
}
function getupdates($up_id) {
$get = bot('getupdates', ['offset' => $up_id]);
return end($get['result']);
}
$id = "1324136519";
while (1) {
$get_up = getupdates($last_up + 1);
$last_up = $get_up['update_id'];
if ($get_up) {
	$message = $get_up['message'];
	$mid = $get_up['message']['message_id'];
	$userID = $message['from']['id'];
	$chat_id = $message['chat']['id'];
	$firstname = $message["from"]["first_name"]; 
     $text = $message['text'];
  if ($text == "/start") {
            bot("sendMessage", [
                "chat_id" => $chat_id,
                "text" =>"ارسݪ اݪيوزر $firstname",
                "reply_to_message_id" => $message_id,
                "parse_mode" => "Markdown",
            ]);
        } elseif(strpos($text,"@",$text1) !== false){
            $text = str_replace("@","",$text);
            $api = file_get_contents("https://abo-khaled.tk/Api/TaM-TaM/TaM-TaM-Users-Check.php?User=$text");
                  $api1 = file_get_contents("https://abo-khaled.tk/Api/TaM-TaM/TaM-TaM-Users-Check.php?User=$text1");
                  $text1 = str_replace("@","",$text1);
            if (!empty($api) and strpos($api,"Анализировать") === false){
                $api = json_decode($api);
                bot("sendMessage",[
                    "chat_id"=>$chat_id,
                    "reply_to_message_id" => $message_id,
                    'text'=>"اݪيوزر متوفر✅",
                    "parse_mode" => "Markdown",
                ]);
            }else{
                bot("sendMessage", [
                    "chat_id" => $chat_id,
                    "text" =>"غير متوفر❌",
                    "reply_to_message_id" => $message_id,
                    "parse_mode" => "Markdown",
                ]);
            }
        }
    }
}