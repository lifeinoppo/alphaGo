<?php 

 function xiaodoubi($words){ 
     $xiaodoubi_url='http://www.xiaodoubi.com/bot/chat.php'; 
     $fields_post=array('chat'=>$words, ); 
     $fields_string=http_build_query($fields_post,'&'); 
      
     $ch=curl_init(); 
     curl_setopt($ch,CURLOPT_POST,1); 
     curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
     curl_setopt($ch,CURLOPT_HEADER,0); 
     curl_setopt($ch,CURLOPT_URL,$xiaodoubi_url); 
     curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string); 
     $backws=curl_exec($ch); 
     curl_close($ch); 
      
     if(preg_match('/微信/i',$backws)) { 
         $backws='block blocked, see what happened '.'/:B-)'; 
     } 
      
     return $backws; 
 } 
  
 //echo xiaodoubi('haha'); 
?> 
