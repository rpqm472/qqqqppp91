<?php
date_default_timezone_set('Asia/Baghdad');



if(isset($update->callback_query)) {
          $chatiId = $update->callback_query->message->chat->id;
   
}



if(!file_exists('config.json')){
	$token = readline('TOKEN: ');
	$id = readline('ID: ');
	file_put_contents('config.json', json_encode(['id'=>$id,'token'=>$token]));

} else {
		  $config = json_decode(file_get_contents('config.json'),1);
	$token = $config['token'];
	$id = $config['id'];
}

if(!file_exists('accounts.json')){
    file_put_contents('accounts.json',json_encode([]));
}
include 'index.php';
try {
	$callback = function ($update, $bot) {
		global $id;
		if($update != null){
		  $config = json_decode(file_get_contents('config.json'),1);
		  $config['filter'] = $config['filter'] != null ? $config['filter'] : 1;
      $accounts = json_decode(file_get_contents('accounts.json'),1);
			if(isset($update->message)){
				$message = $update->message;
				$chatId = $message->chat->id;
				$text = $message->text;
				if($chatId == $id){
					if($text == '/start'){
              $bot->sendphoto([ 'chat_id'=>$chatId,
                  'photo'=>"https://t.me/SIEEDD",
                   'caption'=>'πͺππππ’π πππ§π’ π§π’ππ¬π’ π§π’π’π π’ π',
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'π°π³π³ π°π²π²πΎππ½π π£β','callback_data'=>'login'],
                          ['text'=>'π²πΎπ½πππΎπ» πΏπ°πΆπ΄ π₯βοΈ','callback_data'=>'backakil']],
                      
                    
                      ]
                  ])
              ]);
                  
                 $bot->sendMessage([ '
                 chat_id'=>$chatId,
                  'text'=>"Welcomeπ",
                   'caption'=>'ΩΩΩ ΨͺΨ΅ΩΨ― Ψ·Ψ±ΩΩΩ 1 βΎ',

                ]);

          } elseif($text != null){
          	if($config['mode'] != null){
          		$mode = $config['mode'];
          		if($mode == 'addL'){
          			$ig = new ig(['file'=>'','account'=>['useragent'=>'Instagram 27.0.0.7.97 Android (23/6.0.1; 640dpi; 1440x2392; LGE/lge; RS988; h1; h1; en_US)']]);
          			list($user,$pass) = explode(':',$text);
          			list($headers,$body) = $ig->login($user,$pass);
          			// echo $body;
          			$body = json_decode($body);
          			if(isset($body->message)){
          				if($body->message == 'challenge_required'){
          					$bot->sendMessage([
          							'chat_id'=>$chatId,
          							'text'=>"ΩΩΨ― ΨͺΩ Ψ±ΩΨΆ Ψ§ΩΨ­Ψ³Ψ§Ψ¨ ΩΨ§ΩΩ ΩΨ­ΨΈΩΨ± Ψ§Ω Ψ§ΩΩ ΩΨ·ΩΨ¨ ΩΨ΅Ψ§Ψ―ΩΩβοΈ"
          					]);
          				} else {
          					$bot->sendMessage([
          							'chat_id'=>$chatId,
          							'text'=>"ΩΩΩΩ Ψ§ΩΨ³Ψ± Ψ§Ω Ψ§ΩΩΩΨ²Ψ± Ψ?Ψ·Ψ£ β"
          					]);
          				}
          			} elseif(isset($body->logged_in_user)) {
          				$body = $body->logged_in_user;
          				preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headers, $matches);
								  $CookieStr = "";
								  foreach($matches[1] as $item) {
								      $CookieStr .= $item."; ";
								  }
          				$account = ['cookies'=>$CookieStr,'useragent'=>'Instagram 27.0.0.7.97 Android (23/6.0.1; 640dpi; 1440x2392; LGE/lge; RS988; h1; h1; en_US)'];

          				$accounts[$text] = $account;
          				file_put_contents('accounts.json', json_encode($accounts));
          				$mid = $config['mid'];
          				$bot->sendMessage([
          				      'parse_mode'=>'markdown',
          							'chat_id'=>$chatId,
          							'text'=>"*ΨͺΩ Ψ§ΨΆΨ§ΩΩ Ψ­Ψ³Ψ§Ψ¨ Ψ¬Ψ―ΩΨ― Ψ§ΩΩ Ψ§ΩΨ§Ψ―Ψ§Ω π£.*\n _Username_ : [$user])(instagram.com/$user)\n_Account Name_ : _{$body->full_name}_",
												'reply_to_message_id'=>$mid
          					]);
          				$keyboard = ['inline_keyboard'=>[
										[['text'=> "ΨΆΩΩ ΩΩΩΩ Ψ¬Ψ―ΩΨ― π‘",'callback_data'=>'addL']]
									]];
		              foreach ($accounts as $account => $v) {
		                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'ddd'],['text'=>"ΨͺΨ³Ψ¬ΩΩ Ψ§ΩΨ?Ψ±ΩΨ¬",'callback_data'=>'del&'.$account]];
		              }
		              $keyboard['inline_keyboard'][] = [['text'=>'Ψ§ΩΩΨ§Ψ¦ΩΩ Ψ§ΩΨ±Ψ¦ΩΨ³ΩΨ© β','callback_data'=>'back']];
		              $bot->editMessageText([
		                  'chat_id'=>$chatId,
		                  'message_id'=>$mid,
		                  'text'=>"Hiπ
THE IS YOU ACCOUNTS ΰΏ",
		                  'reply_markup'=>json_encode($keyboard)
		              ]);
		              $config['mode'] = null;
		              $config['mid'] = null;
		              file_put_contents('config.json', json_encode($config));
          			}
          		}  elseif($mode == 'selectFollowers'){
          		  if(is_numeric($text)){
          		    bot('sendMessage',[
          		        'chat_id'=>$chatId,
          		        'text'=>"ΨͺΩ Ψ§ΩΨͺΨΉΨ―ΩΩ.",
          		        'reply_to_message_id'=>$config['mid']
          		    ]);
          		    $config['filter'] = $text;
          		    $bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                      'text'=>"Ψ§ΩΨͺΨ­ΩΩ Ψ¨ΩΨ¨ΩΨͺ $name ",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'Ψ§ΨΆΩ Ψ­Ψ³Ψ§Ψ¨ ','callback_data'=>'login']],
                          [['text'=>'β¦ Ψ·Ψ±Ω Ψ³Ψ­Ψ¨ Ψ§ΩΩΩΨ²Ψ±Ψ§Ψͺ β¦','callback_data'=>'grabber']],
                          [['text'=>'Ψ¨Ψ―Ψ‘ Ψ§ΩΨ΅ΩΨ― β','callback_data'=>'run'],['text'=>'Ψ§ΩΩΨ§Ω Ψ§ΩΨ΅ΩΨ―β','callback_data'=>'stop']],
                          [['text'=>'Ψ­Ψ§ΩΩ Ψ§ΩΨ­Ψ³Ψ§Ψ¨Ψ§Ψͺ β','callback_data'=>'status'],['text'=>'ΩΨ³Ω Ψ?Ψ§Ψ΅ β','callback_data'=>'statusakil']],
                          [['text'=>' Ψ§ΩΩΩΨ§Ωβ','url'=>'t.me/ARAB_SHIELD'],['text'=>'Ψ§ΩΩΨ·ΩΨ± ε½‘β','url'=>'t.me/SIEEDD']],
                      ]
                  ])
                  ]);
          		    $config['mode'] = null;
		              $config['mid'] = null;
		              file_put_contents('config.json', json_encode($config));
          		  } else {
          		    bot('sendMessage',[
          		        'chat_id'=>$chatId,
          		        'text'=>'- ΩΨ±Ψ¬Ω Ψ§Ψ±Ψ³Ψ§Ω Ψ±ΩΩ ΩΩΨ· .'
          		    ]);
          		  }
          		} else {
          		  switch($config['mode']){
          		    case 'search':
          		      $config['mode'] = null;
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php search.php');
          		      break;
          		      case 'followers':
          		      $config['mode'] = null;
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php followers.php');
          		      break;
          		      case 'following':
          		      $config['mode'] = null;
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php following.php');
          		      break;
          		      case 'hashtag':
          		      $config['mode'] = null;
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php hashtag.php');
          		      break;
          		  }
          		}
          	}
          }
				} else {
				

               if($text == '/start' ){ 
               
              
               
                
               $bot->sendMessage([
				
                			'chat_id'=>$chatId,
					
                					'text'=>"ΩΨ°Ψ§ Ψ§ΩΨ¨ΩΨͺ ΩΨ―ΩΩΨΉ Ω ΩΩΨ³ ΩΨ¬Ψ§ΩΩ 
ΩΩΩΩΩ Ψ§ΩΨ­Ψ΅ΩΩ ΨΉΩΩ ΩΨ³Ψ?Ω ΩΩ Ψ§ΩΨ¨ΩΨͺ Ψ¨ΨΉΨ― Ψ΄Ψ±Ψ§Ψ¦Ω ΩΩ Ψ§ΩΩΨ·ΩΨ± ε½‘ 
Ψ§ΨΆΨΊΨ· ΩΩ Ψ§ΩΨ§Ψ³ΩΩ ΩΩΨ±Ψ§Ψ³ΩΩ Ψ§ΩΩΨ·ΩΨ± ε½‘ π",
				
                								'reply_markup'=>json_encode([
        
                								          'inline_keyboard'=>[
             
                								                   [['text'=>'Ψ§ΨΆΨΊΨ· ΩΩΨ±Ψ§Ψ³ΩΩ Ψ§ΩΩΨ·ΩΨ± ε½‘ π£','url'=>'t.me/SIEEDD']],
           
                								                              [['text'=>'Ψ§ΨΆΨΊΨ· ΩΩΨ§','callback_data'=>'SIEEDD']]
          
                			       ]
 
                			   	])
                		
	]);
	               				
				
								
					
					
					
				
				
                      }
					
				}
				
			} elseif(isset($update->callback_query)) {
          $chatId = $update->callback_query->message->chat->id;
          $mid = $update->callback_query->message->message_id;
          $data = $update->callback_query->data;
          echo $data;
          
          
 
                           
          if($data == 'login'){

        		$keyboard = ['inline_keyboard'=>[
									[['text'=>"ΨΆΩΩ ΩΩΩΩ Ψ¬Ψ―ΩΨ― π‘",'callback_data'=>'addL']]
									]];
		              foreach ($accounts as $account => $v) {
		                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'ddd'],['text'=>"ΨͺΨ³Ψ¬ΩΩ Ψ§ΩΨ?Ψ±ΩΨ¬",'callback_data'=>'del&'.$account]];
		              }
		              $keyboard['inline_keyboard'][] = [['text'=>'Ψ§ΩΩΨ§Ψ¦ΩΩ Ψ§ΩΨ±Ψ¦ΩΨ³ΩΨ© β','callback_data'=>'back']];
		              $bot->sendMessage([
		                  'chat_id'=>$chatId,
		                  'message_id'=>$mid,
		                   'text'=>"Hiπ
THE IS YOU ACCOUNTS ΰΏ",
		                  'reply_markup'=>json_encode($keyboard)
		              ]);
		              
		} elseif($data == 'SIEEDD'){
		  
		  
		  
		                       
          
     $bot->sendMessage([
                      'chat_id'=>$chatId,
                      
                      'text'=>"Ψ§ΩΨͺΨ­ΩΩ Ψ¨ΩΨ¨ΩΨͺ $name ",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'ΩΨ·ΩΨ± ε½‘','url'=>'t.me/SIEEDD'],['text'=>'ΨͺΩΨ§Ψ΅Ω','url'=>'t.me/SIEEDD']],
                           [['text'=>'Ψ§Ψ΄ΨͺΨ±Ψ§Ω Ψ¨ΩΨ¨ΩΨͺ','url'=>'t.me/C_Y_L']],
                           [['text'=>'ΩΩΩ Ψ§ΩΨ¨ΩΨͺ','callback_data'=>'akilf'],['text'=>'Ψ±Ψ¬ΩΨΉ','callback_data'=>'hback']],
                           
 ]
                  ])
              ]);
				
		              
		              
		              
		                  } elseif($data == 'hback'){
          	$bot->editMessageText([
                      'chat_id'=>$chatId,
					
                      'message_id'=>$mid,
                					'text'=>"ΩΨ°Ψ§ Ψ§ΩΨ¨ΩΨͺ ΩΨ―ΩΩΨΉ Ω ΩΩΨ³ ΩΨ¬Ψ§ΩΩ 
ΩΩΩΩΩ Ψ§ΩΨ­Ψ΅ΩΩ ΨΉΩΩ ΩΨ³Ψ?Ω ΩΩ Ψ§ΩΨ¨ΩΨͺ Ψ¨ΨΉΨ― Ψ΄Ψ±Ψ§Ψ¦Ω ΩΩ Ψ§ΩΩΨ·ΩΨ± ε½‘ 
Ψ§ΨΆΨΊΨ· ΩΩ Ψ§ΩΨ§Ψ³ΩΩ ΩΩΨ±Ψ§Ψ³ΩΩ Ψ§ΩΩΨ·ΩΨ± ε½‘ π",
				
                								'reply_markup'=>json_encode([
        
                								          'inline_keyboard'=>[
             
                								                   [['text'=>'Ψ§ΨΆΨΊΨ· ΩΩΨ±Ψ§Ψ³ΩΩ Ψ§ΩΩΨ·ΩΨ± ε½‘ π£','url'=>'t.me/SIEEDD']],
           
                								                              [['text'=>'Ψ·ΩΨ¨ Ψ§Ψ΄ΨͺΨ±Ψ§Ω ΩΩ Ψ§ΩΨ§Ψ―ΩΩ','callback_data'=>'SIEEDD']]
          
                			       ]
 
                			   	])
                		
	]);
	               				
				
								

		              
		              
		              
		              
		              
		              
		              
		              
		              
          } elseif($data == 'addL'){

          	$config['mode'] = 'addL';
          	$config['mid'] = $mid;
          	file_put_contents('config.json', json_encode($config));
          	$bot->sendMessage([
          			'chat_id'=>$chatId,
          			'text'=>"Ψ§Ψ±Ψ³Ω Ψ§ΩΨ­Ψ³Ψ§Ψ¨ Ψ¨ΩΨ°Ψ§ Ψ§ΩΨ΄ΩΩ π   `user:pass`",
          			'parse_mode'=>'markdown'
          	]);
          } elseif($data == 'grabber'){

            $for = $config['for'] != null ? $config['for'] : 'Ψ­Ψ―Ψ― Ψ§ΩΨ­Ψ³Ψ§Ψ¨';
            $count = count(explode("\n", file_get_contents($for)));
            $bot->editMessageText([
                'chat_id'=>$chatId,
                'message_id'=>$mid,
                'text'=>"Users collection page. \n - Users : $count \n - For Account : $for",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>'Ψ³Ψ­Ψ¨ ΩΩ ΩΩΩΨ§Ψͺβ¨','callback_data'=>'search']],
                        [['text'=>'ΩΨ§Ψ΄ΨͺΨ§Ψ¬','callback_data'=>'hashtag'],['text'=>'π ΩΩ Ψ§ΩΨ§ΩΨ³Ψ¨ΩΩΨ±','callback_data'=>'explore']],
                        [['text'=>'Followers','callback_data'=>'followers'],['text'=>"Following",'callback_data'=>'following']],
                        [['text'=>"Ψ§ΩΨ­Ψ³Ψ§Ψ¨ Ψ§ΩΩΨ­Ψ―Ψ― : $for",'callback_data'=>'for']],
                        [['text'=>'ΩΨ³ΨͺΩ ΩΩΨ²Ψ±Ψ§Ψͺ Ψ¬Ψ―ΩΨ―Ω βοΈ','callback_data'=>'newList'],['text'=>'ΩΨ³ΨͺΩ ΩΩΨ²Ψ±Ψ§Ψͺ Ψ³Ψ§Ψ¨ΩΩ β οΈ','callback_data'=>'append']],
                        [['text'=>'Ψ§ΩΩΨ§Ψ¦ΩΩ Ψ§ΩΨ±Ψ¦ΩΨ³ΩΨ© β','callback_data'=>'back']],
                    ]
                ])
            ]);
            
            
            
            } elseif($data == 'akilf'){
            
            
$bot->sendMessage([
                      'chat_id'=>$chatId,
                      
                      'text'=>"https://t.me/SIEEDD/824",
            
            
                        ]);
            
            
            
            
            
            
            
            
            
            
          } elseif($data == 'search'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"Ψ§ΩΨ§Ω ΩΩ Ψ¨Ψ£Ψ±Ψ³Ψ§Ω Ψ§ΩΩΩΩΩ Ψ§ΩΨͺΨ±ΩΨ― Ψ§ΩΨ¨Ψ­Ψ« ΨΉΩΩΩΨ§ Ω Ψ§ΩΨΆΨ§ ΩΩΩΩΩ ΩΩ Ψ§Ψ³ΨͺΨ?Ψ―Ψ§Ω Ψ§ΩΨ«Ψ± ΩΩ ΩΩΩΩ ΨΉΩ Ψ·Ψ±ΩΩ ΩΨΆΨΉ ΩΩΨ§Ψ΅Ω Ψ¨ΩΩ Ψ§ΩΩΩΩΨ§ΨͺβοΈ"
            ]);
            $config['mode'] = 'search';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'followers'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"Ψ§ΩΨ§Ω ΩΩ Ψ¨Ψ£Ψ±Ψ³Ψ§Ω Ψ§ΩΩΩΨ²Ψ± Ψ§ΩΨͺΨ±ΩΨ― Ψ³Ψ­Ψ¨ ΩΨͺΨ§Ψ¨ΨΉΩΩ Ω Ψ§ΩΨΆΨ§ ΩΩΩΩΩ ΩΩ Ψ§Ψ³ΨͺΨ?Ψ―Ψ§Ω Ψ§ΩΨ«Ψ± ΩΩ ΩΩΨ²Ψ± ΨΉΩ Ψ·Ψ±ΩΩ ΩΨΆΨΉ ΩΩΨ§Ψ΅Ω Ψ¨ΩΩ Ψ§ΩΩΩΨ²Ψ±Ψ§Ψͺ πͺ"
            ]);
            $config['mode'] = 'followers';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'following'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"Ψ§ΩΨ§Ω ΩΩ Ψ¨Ψ£Ψ±Ψ³Ψ§Ω Ψ§ΩΩΩΨ²Ψ± Ψ§ΩΨͺΨ±ΩΨ― Ψ³Ψ­Ψ¨ Ψ§ΩΨ°Ω  ΩΨͺΨ§Ψ¨ΨΉΩΩ Ω Ψ§ΩΨΆΨ§ ΩΩΩΩΩ ΩΩ Ψ§Ψ³ΨͺΨ?Ψ―Ψ§Ω Ψ§ΩΨ«Ψ± ΩΩ ΩΩΨ²Ψ± ΨΉΩ Ψ·Ψ±ΩΩ ΩΨΆΨΉ ΩΩΨ§Ψ΅Ω Ψ¨ΩΩ Ψ§ΩΩΩΨ²Ψ±Ψ§Ψͺ πͺ"
            ]);
            $config['mode'] = 'following';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'hashtag'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"Ψ§ΩΨ§Ω ΩΩ Ψ¨Ψ£Ψ±Ψ³Ψ§Ω Ψ§ΩΩΨ§Ψ΄ΨͺΨ§Ω Ψ¨Ψ―ΩΩ ΨΉΩΨ§ΩΩ # ΩΩΩΩΩ π§ΏΨ§Ψ³ΨͺΨ?Ψ―Ψ§Ω ΩΨ§Ψ΄ΨͺΨ§Ω ΩΨ§Ψ­Ψ― ΩΩΨ·"
            ]);
            $config['mode'] = 'hashtag';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'newList'){
            file_put_contents('a','new');
            $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ΨͺΩ Ψ§Ψ?ΨͺΩΨ§Ψ± βοΈ ΩΨ³ΨͺΨ©Ψ© ΩΩΨ²Ψ±Ψ§Ψͺ Ψ¬Ψ―ΩΨ―Ω Ψ¨ΩΨ¬Ψ§Ψ­",
							'show_alert'=>1
						]);
          } elseif($data == 'append'){
            file_put_contents('a', 'ap');
            $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ΨͺΩ Ψ§Ψ?ΨͺΩΨ§Ψ± β οΈ ΩΨ³ΨͺΨ©Ψ© ΩΩΨ²Ψ±Ψ§Ψͺ Ψ³Ψ§Ψ¨ΩΩ Ψ¨ΩΨ¬Ψ§Ψ­",
							'show_alert'=>1
						]);

          } elseif($data == 'for'){
            if(!empty($accounts)){
            $keyboard = [];
             foreach ($accounts as $account => $v) {
                $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'forg&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"Ψ§Ψ?ΨͺΨ§Ψ± Ψ§ΩΨ­Ψ³Ψ§Ψ¨",
                  'reply_markup'=>json_encode($keyboard)
              ]);
            } else {
              $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ΩΩ Ψ¨ΨͺΨ³Ψ¬ΩΩ Ψ­Ψ³Ψ§Ψ¨ Ψ§ΩΩΨ§ β",
							'show_alert'=>1
						]);
            }
          } elseif($data == 'selectFollowers'){
            bot('sendMessage',[
                'chat_id'=>$chatId,
                'text'=>'ΩΩ Ψ¨Ψ£Ψ±Ψ³Ψ§Ω ΨΉΨ―Ψ― ΩΨͺΨ§Ψ¨ΨΉΩΩ .'
            ]);
            $config['mode'] = 'selectFollowers';
          	$config['mid'] = $mid;
          	file_put_contents('config.json', json_encode($config));
          } elseif($data == 'run'){
            if(!empty($accounts)){
            $keyboard = [];
             foreach ($accounts as $account => $v) {
                $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'start&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"Ψ­Ψ―Ψ― Ψ­Ψ³Ψ§Ψ¨",
                  'reply_markup'=>json_encode($keyboard)
              ]);
            } else {
              $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ΩΩ Ψ¨ΨͺΨ³Ψ¬ΩΩ Ψ­Ψ³Ψ§Ψ¨ Ψ§ΩΩΨ§ β",
							'show_alert'=>1
						]);
            }
          }elseif($data == 'stop'){
            if(!empty($accounts)){
            $keyboard = [];
             foreach ($accounts as $account => $v) {
                $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'stop&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"Ψ§Ψ?ΨͺΨ§Ψ± Ψ§ΩΨ­Ψ³Ψ§Ψ¨",
                  'reply_markup'=>json_encode($keyboard)
              ]);
            } else {
              $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ΩΩ Ψ¨ΨͺΨ³Ψ¬ΩΩ Ψ­Ψ³Ψ§Ψ¨ Ψ§ΩΩΨ§ β",
							'show_alert'=>1
						]);
            }
          }elseif($data == 'stopgr'){
            shell_exec('screen -S gr -X quit');
            $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ΨͺΩ Ψ§ΩΨ§ΩΨͺΩΨ§Ψ‘ ΩΩ Ψ§ΩΨ³Ψ­Ψ¨",
						// 	'show_alert'=>1
						]);
						$for = $config['for'] != null ? $config['for'] : 'Select Account';
            $count = count(explode("\n", file_get_contents($for)));
						$bot->editMessageText([
                'chat_id'=>$chatId,
                'message_id'=>$mid,
                'text'=>"Users collection page. \n - Users : $count \n - For Account : $for",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                       [['text'=>'Ψ³Ψ­Ψ¨ ΩΩ ΩΩΩΨ§Ψͺβ¨','callback_data'=>'search']],
                        [['text'=>'ΩΨ§Ψ΄ΨͺΨ§Ψ¬','callback_data'=>'hashtag'],['text'=>'π ΩΩ Ψ§ΩΨ§ΩΨ³Ψ¨ΩΩΨ±','callback_data'=>'explore']],
                        [['text'=>'Followers','callback_data'=>'followers'],['text'=>"Following",'callback_data'=>'following']],
                        [['text'=>"Ψ§ΩΨ­Ψ³Ψ§Ψ¨ Ψ§ΩΩΨ­Ψ―Ψ― : $for",'callback_data'=>'for']],
                        [['text'=>'ΩΨ³ΨͺΩ ΩΩΨ²Ψ±Ψ§Ψͺ Ψ¬Ψ―ΩΨ―Ω βοΈ','callback_data'=>'newList'],['text'=>'ΩΨ³ΨͺΩ ΩΩΨ²Ψ±Ψ§Ψͺ Ψ³Ψ§Ψ¨ΩΩ β οΈ','callback_data'=>'append']],
                        [['text'=>'Ψ§ΩΩΨ§Ψ¦ΩΩ Ψ§ΩΨ±Ψ¦ΩΨ³ΩΨ© β','callback_data'=>'back']],
                    ]
                ])
            ]);
          } elseif($data == 'explore'){
            exec('screen -dmS gr php explore.php');
          } elseif($data == 'status'){
					$status = '';
					foreach($accounts as $account => $ac){
						$c = explode(':', $account)[0];
						$x = exec('screen -S '.$c.' -Q select . ; echo $?');
						if($x == '0'){
				        $status .= "*$account* ~> _Working_\n";
				    } else {
				        $status .= "*$account* ~> _Stop_\n";
				    }
					}
					$bot->sendMessage([
							'chat_id'=>$chatId,
							'text'=>"Ψ­Ψ§ΩΩ Ψ§ΩΨ­Ψ³Ψ§Ψ¨Ψ§Ψͺ : \n\n $status",
							'parse_mode'=>'markdown'
						]);
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
				} elseif($data == 'backakil'){
          	$bot->sendMessage([
                      'chat_id'=>$chatId,
                     'text'=> "ΩΩΨ§ ΩΨ§Ψ¦ΩΩ Ψ§ΩΨ΅ΩΨ―π«",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'β¬Ψ£ΨΆΨ§ΩΩ Ψ­Ψ³Ψ§Ψ¨ ΩΩΩΩ Ψ¬Ψ―ΩΨ―β¬','callback_data'=>'login']],
                          [['text'=>'β¦ Ψ·Ψ±Ω Ψ³Ψ­Ψ¨ Ψ§ΩΩΩΨ²Ψ±Ψ§Ψͺ β¦','callback_data'=>'grabber']],
                          [['text'=>'Ψ¨Ψ―Ψ‘ Ψ§ΩΨ΅ΩΨ― β','callback_data'=>'run'],['text'=>'Ψ§ΩΩΨ§Ω Ψ§ΩΨ΅ΩΨ―β','callback_data'=>'stop']],
                          [['text'=>'Ψ­Ψ§ΩΩ Ψ§ΩΨ­Ψ³Ψ§Ψ¨Ψ§Ψͺ β','callback_data'=>'status'],['text'=>'ΩΨ³Ω Ψ?Ψ§Ψ΅ β','callback_data'=>'statusakil']],
 [['text'=>' Ψ§ΩΩΩΨ§Ωβ','url'=>'t.me/ARAB_SHIELD'],['text'=>'Ψ§ΩΩΨ·ΩΨ± ε½‘β','url'=>'t.me/SIEEDD']],
                      ]
                  ])
                  ]);		
						
						
						
						
						
						
						
		} elseif($data == 'statusakil'){
          	$bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                     'text'=> "πWelcomeπ $name",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'ΩΩΨ―ΩΩ ΨͺΨΉΩΩΩΩ ΩΩΨ΅ΩΨ―π','callback_data'=>'akilx1']],
                          [['text'=>'Ψ§ΩΩΩΨ§ΩβοΈ','callback_data'=>'akilx2']],
                          [['text'=>'Ψ§ΩΩΨ·ΩΨ±','callback_data'=>'akilx3']],
                          [['text'=>'ID','callback_data'=>'akilx4'],['text'=>'BACK','callback_data'=>'back']],
 [['text'=>' Ψ§ΩΩΩΨ§Ωβ','url'=>'t.me/ARAB_SHIELD'],['text'=>'Ψ§ΩΩΨ·ΩΨ± ε½‘β','url'=>'t.me/SIEEDD']],
                      ]
                  ])
                  ]);				
						
						
						                  } elseif($data == 'akilx1'){
          	$bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                     'text'=> "Ψ¨ΨΉΨ― ΩΨ§ Ψ΅ΩΨ±Ψͺπ",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'Ψ±Ψ¬ΩΨΉ','callback_data'=>'statusakil']],
                          ]
                  ])
                  ]);
                  
												
						} elseif($data == 'akilx2'){
          	$bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                     'text'=>"@ARAB_SHIELD",








                  
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'Ψ±Ψ¬ΩΨΉ','callback_data'=>'statusakil']],
                          ]
                  ])
                  ]);
                  
						                  } elseif($data == 'akilx3'){
          	$bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                     'text'=> "@SIEEDD",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'Ψ±Ψ¬ΩΨΉ','callback_data'=>'statusakil']],
                          ]
                  ])
                  ]);
						
						
						
						
			                  } elseif($data == 'akilx4'){
          	$bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                     'text'=> "Ψ§ΩΨ―ΩΩ -> $chatId 
$token = $token ",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'Ψ±Ψ¬ΩΨΉ','callback_data'=>'statusakil']],
                          ]
                  ])
                  ]);
                  		
						
						
				} elseif($data == 'back'){
          	$bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                     'text'=> "ΩΩΨ§ ΩΨ§Ψ¦ΩΩ Ψ§ΩΨ΅ΩΨ―π«",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'β¬Ψ£ΨΆΨ§ΩΩ Ψ­Ψ³Ψ§Ψ¨ ΩΩΩΩ Ψ¬Ψ―ΩΨ―β¬','callback_data'=>'login']],
                          [['text'=>'β¦ Ψ·Ψ±Ω Ψ³Ψ­Ψ¨ Ψ§ΩΩΩΨ²Ψ±Ψ§Ψͺ β¦','callback_data'=>'grabber']],
                          [['text'=>'Ψ¨Ψ―Ψ‘ Ψ§ΩΨ΅ΩΨ― β','callback_data'=>'run'],['text'=>'Ψ§ΩΩΨ§Ω Ψ§ΩΨ΅ΩΨ―β','callback_data'=>'stop']],
                          [['text'=>'Ψ­Ψ§ΩΩ Ψ§ΩΨ­Ψ³Ψ§Ψ¨Ψ§Ψͺ β','callback_data'=>'status'],['text'=>'ΩΨ³Ω Ψ?Ψ§Ψ΅ β','callback_data'=>'statusakil']],
 [['text'=>' Ψ§ΩΩΩΨ§Ωβ','url'=>'t.me/ARAB_SHIELD'],['text'=>'Ψ§ΩΩΨ·ΩΨ± ε½‘β','url'=>'t.me/SIEEDD']],
                      ]
                  ])
                  ]);
          } else {
          	$data = explode('&',$data);
          	if($data[0] == 'del'){

          		unset($accounts[$data[1]]);
          		file_put_contents('accounts.json', json_encode($accounts));
              $keyboard = ['inline_keyboard'=>[
							[['text'=>"ΨΆΩΩ ΩΩΩΩ Ψ¬Ψ―ΩΨ― π‘",'callback_data'=>'addL']]
									]];
		              foreach ($accounts as $account => $v) {
		                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'ddd'],['text'=>"ΨͺΨ³Ψ¬ΩΩ Ψ§ΩΨ?Ψ±ΩΨ¬",'callback_data'=>'del&'.$account]];
		              }
		              $keyboard['inline_keyboard'][] = [['text'=>'Ψ§ΩΩΨ§Ψ¦ΩΩ Ψ§ΩΨ±Ψ¦ΩΨ³ΩΨ© β','callback_data'=>'back']];
		              $bot->editMessageText([
		                  'chat_id'=>$chatId,
		                  'message_id'=>$mid,
		                    'text'=>"Hiπ
THE IS YOU ACCOUNTS ΰΏ",
		                  'reply_markup'=>json_encode($keyboard)
		              ]);
          	} elseif($data[0] == 'moveList'){
          	  file_put_contents('list', $data[1]);
          	  $keyboard = [];
          	  foreach ($accounts as $account => $v) {
                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'moveListTo&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"Ψ§Ψ?ΨͺΨ± Ψ§ΩΨ­Ψ³Ψ§Ψ¨ Ψ§ΩΨ°Ω ΨͺΨ±ΩΨ― ΩΩΩ Ψ§ΩΩΨ³ΨͺΩ Ψ§ΩΩΩ",
                  'reply_markup'=>json_encode($keyboard)
	              ]);
          	} elseif($data[0] == 'moveListTo'){
          	  $keyboard = [];
          	  file_put_contents($data[1], file_get_contents(file_get_contents('list')));
          	  unlink(file_get_contents('list'));
          	  $keyboard['inline_keyboard'][] = [['text'=>'Ψ§ΩΩΨ§Ψ¦ΩΩ Ψ§ΩΨ±Ψ¦ΩΨ³ΩΨ© β','callback_data'=>'back']];
          	  $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"ΨͺΩ ΩΩΩ Ψ§ΩΩΨ³ΨͺΩ Ψ§ΩΩ Ψ§ΩΨ­Ψ³Ψ§Ψ¨  β".$data[1],
                  'reply_markup'=>json_encode($keyboard)
	              ]);
          	} elseif($data[0] == 'forg'){
          	  $config['for'] = $data[1];
          	  file_put_contents('config.json',json_encode($config));
              $for = $config['for'] != null ? $config['for'] : 'Select';
              $count = count(file_get_contents($for));
              $bot->editMessageText([
                'chat_id'=>$chatId,
                'message_id'=>$mid,
                'text'=>"Users collection page. \n - Users : $count \n - For Account : $for",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                            [['text'=>'Ψ³Ψ­Ψ¨ ΩΩ ΩΩΩΨ§Ψͺβ¨','callback_data'=>'search']],
                        [['text'=>'ΩΨ§Ψ΄ΨͺΨ§Ψ¬','callback_data'=>'hashtag'],['text'=>'π ΩΩ Ψ§ΩΨ§ΩΨ³Ψ¨ΩΩΨ±','callback_data'=>'explore']],
                        [['text'=>'Followers','callback_data'=>'followers'],['text'=>"Following",'callback_data'=>'following']],
                        [['text'=>"Ψ§ΩΨ­Ψ³Ψ§Ψ¨ Ψ§ΩΩΨ­Ψ―Ψ― : $for",'callback_data'=>'for']],
                        [['text'=>'ΩΨ³ΨͺΩ ΩΩΨ²Ψ±Ψ§Ψͺ Ψ¬Ψ―ΩΨ―Ω βοΈ','callback_data'=>'newList'],['text'=>'ΩΨ³ΨͺΩ ΩΩΨ²Ψ±Ψ§Ψͺ Ψ³Ψ§Ψ¨ΩΩ β οΈ','callback_data'=>'append']],
                        [['text'=>'Ψ§ΩΩΨ§Ψ¦ΩΩ Ψ§ΩΨ±Ψ¦ΩΨ³ΩΨ© β','callback_data'=>'back']],
                    ]
                ])
            ]);
          	} elseif($data[0] == 'start'){
          	  file_put_contents('screen', $data[1]);
          	  $bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                       'text'=> "Ψ§ΩΩΨ§ Ψ¨Ω ΩΨ±Ω Ψ§Ψ?Ψ±Ω ΨΉΨ²ΩΨ²Ω βοΈ
Ψ§Ψ?ΨͺΨ± ΩΨ§ ΨͺΨ±ΩΨ―Ω ΩΩ Ψ§ΩΨ§Ψ³ΩΩ π",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'β¬Ψ£ΨΆΨ§ΩΩ Ψ­Ψ³Ψ§Ψ¨ ΩΩΩΩ Ψ¬Ψ―ΩΨ―β¬','callback_data'=>'login']],
                          [['text'=>'β¦ Ψ·Ψ±Ω Ψ³Ψ­Ψ¨ Ψ§ΩΩΩΨ²Ψ±Ψ§Ψͺ β¦','callback_data'=>'grabber']],
                          [['text'=>'Ψ¨Ψ―Ψ‘ Ψ§ΩΨ΅ΩΨ― β','callback_data'=>'run'],['text'=>'Ψ§ΩΩΨ§Ω Ψ§ΩΨ΅ΩΨ―β','callback_data'=>'stop']],
                          [['text'=>'Ψ­Ψ§ΩΩ Ψ§ΩΨ­Ψ³Ψ§Ψ¨Ψ§Ψͺ β','callback_data'=>'status'],['text'=>'ΩΨ³Ω Ψ?Ψ§Ψ΅ β','callback_data'=>'statusakil']],
 [['text'=>' Ψ§ΩΩΩΨ§Ωβ','url'=>'t.me/ARAB_SHIELD'],['text'=>'Ψ§ΩΩΨ·ΩΨ± ε½‘β','url'=>'t.me/SIEEDD']],
                      ]
                  ])
                  ]);
              exec('screen -dmS '.explode(':',$data[1])[0].' php start.php');
              $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"*Ψ¨Ψ―Ψ‘ Ψ§ΩΨ΅ΩΨ―.*\n Account: `".explode(':',$data[1])[0].'`',
                'parse_mode'=>'markdown'
              ]);
          	} elseif($data[0] == 'stop'){
          	  $bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                      'text'=>"Ψ§ΩΩΨ§ Ψ¨Ω ΩΨ±Ω Ψ§Ψ?Ψ±Ω ΨΉΨ²ΩΨ²Ω βοΈ
Ψ§Ψ?ΨͺΨ± ΩΨ§ ΨͺΨ±ΩΨ―Ω ΩΩ Ψ§ΩΨ§Ψ³ΩΩ π",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'β¬Ψ£ΨΆΨ§ΩΩ Ψ­Ψ³Ψ§Ψ¨ ΩΩΩΩ Ψ¬Ψ―ΩΨ―β¬','callback_data'=>'login']],
                          [['text'=>'β¦ Ψ·Ψ±Ω Ψ³Ψ­Ψ¨ Ψ§ΩΩΩΨ²Ψ±Ψ§Ψͺ β¦','callback_data'=>'grabber']],
                          [['text'=>'Ψ¨Ψ―Ψ‘ Ψ§ΩΨ΅ΩΨ― β','callback_data'=>'run'],['text'=>'Ψ§ΩΩΨ§Ω Ψ§ΩΨ΅ΩΨ―β','callback_data'=>'stop']],
                          [['text'=>'Ψ­Ψ§ΩΩ Ψ§ΩΨ­Ψ³Ψ§Ψ¨Ψ§Ψͺ β','callback_data'=>'status'],['text'=>'ΩΨ³Ω Ψ?Ψ§Ψ΅ β','callback_data'=>'statusakil']],
 [['text'=>' Ψ§ΩΩΩΨ§Ωβ','url'=>'t.me/ARAB_SHIELD'],['text'=>'Ψ§ΩΩΨ·ΩΨ± ε½‘β','url'=>'t.me/SIEEDD']],
                      ]
                    ])
                  ]);
              exec('screen -S '.explode(':',$data[1])[0].' -X quit');
          	}
          }
			}
		}
	};
	$bot = new EzTG(array('throw_telegram_errors'=>false,'token' => $token, 'callback' => $callback));
} catch(Exception $e){
	echo $e->getMessage().PHP_EOL;
	sleep(1);
}
