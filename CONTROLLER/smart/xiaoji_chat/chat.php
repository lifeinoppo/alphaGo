<?php
/*
  function provider for chat here 
  thks to �Ű׹����ң� ����΢�Ź��ںſ������й�����
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
					return "˯���~~~";
					break;
				case 2 : 
					return "����������~~~";
					break;
				case 3 : 
					return "�㻰�ö࣬������~~~";
					break;
				case 1\4 : 
					return "������~~~";
					break;
				case 5 : 
					return "����͵������~~~";
					break;
				default : 
					return "�ݰ�~~~";
					break;
				
			}
			
		}
		
		
		
		
		
		
	}
	



?>