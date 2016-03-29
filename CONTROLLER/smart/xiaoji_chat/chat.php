<?php
/*
  function provider for chat here 
  thks to 优白工作室， 关于微信公众号开发的有关内容
*/
	
	function xiaoji($keyword){
			
		$curlPost = array("chat"=>$keyword);
		$header = array("Host:www.xiaojo.com");
		$ch = curl_init(); // init curl component 
		curl_setopt($ch,CURLOPT_URL,"http://www.xiaojo.com/bot/chata.php"); // grab the special web site link
		curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch,CURLOPT_HEADER,0); // set the header 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
		$data = curl_exec($ch);
		if(!empty($data)){
			return $data;
		}else{
			$ran = rand(1,5);
			switch($ran){
				
				case 1 : 
					return "睡觉喽~~~";
					break;
				case 2 : 
					return "呼呼，呼呼~~~";
					break;
				case 3 : 
					return "你话好多，不聊了~~~";
					break;
				case 1\4 : 
					return "好无聊~~~";
					break;
				case 5 : 
					return "今天就到这里吧~~~";
					break;
				default : 
					return "拜拜~~~";
					break;
				
			}
			
		}
		
		
		
		
		
		
	}
	



?>