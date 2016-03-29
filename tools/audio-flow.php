<?php


/**
 * Class Generator
 *  Generator 类，具体网址和字符串处理
 *
 */

 
 // wrapper them into one class file later if necessary
 // do not polute the namespace

    function updateMusic($keyword){
		$startshouldbe = "mp3";
		if(strstr($keyword,$startshouldbe)){
			return true;
		}else{
			return false;
		}
		
	}
	
	
	function generateMusic($keyword)
    {
		if(updateMusic($keyword)){
			$pos_str = explode(' ',$keyword); // is an array
			$name = $pos_str[0];
			$link = $pos_str[1];
			// store the song name and links 
			file_put_contents("songname.txt",$name);  
			file_put_contents("songlink.txt",$link);  
			// end of store of song info 
			return "success";
		}else{
			// temporarily put here 
			return "failed";
		}
	}

	function generateMusicTitle($keyword){
		$startshouldbe = "update_title";
		// add updateMusicTitle fucntion  later 
		
		
	}
   

?>