<?php
// require('PHPMailer/PHPMailerAutoload.php');

require_once("PHPMailer/class.smtp.php"); 
require_once("PHPMailer/class.phpmailer.php");  
require("config.php");

	// 弄成 动态 设置接口 , sendmail($config)


	function sendmail(){
		
			global $_INFO;
			$mail = new PHPMailer();
			$mail->CharSet = "UTF-8";      // 设置编码  
  
			$mail->IsSMTP();  
			$mail->SMTPAuth = true;                // 设置为安全验证方式  
			$mail->Host     = "smtp.sina.com";        // SMTP服务器地址  
			$mail->Username = $_INFO['mail_username'];      // 登录用户名  
			$mail->Password = $_INFO['mail_userpass'];               // 登录密码  
			  
			$mail->From = $_INFO['mail_username'];        // 发件人地址(username@163.com)  
			$mail->FromName = "pushforalphago";      
		  
			$mail->WordWrap   = 50;  
			$mail->IsHTML(true);            // 是否支持html邮件，true 或false  
					 
			$mail->AddAddress("jxcjxcjzx@sina.com");        //客户邮箱地址  
			//$mail->Subject = "【反馈邮件】";  
			$mail->Subject = "Hi from alphago";  
			$mail->Body    = "Hi~~, jxcjxcjzx, welcome to php world ";  
			if(!$mail->Send()){  			  
			   return  $mail->ErrorInfo;    
			}else{
				return "";
			}  
				
	}
	
	function mail_notification($notification){
		
			// add check empty for $notification
			
			$mail = new PHPMailer();
			$mail->CharSet = "UTF-8";      // 设置编码  
  
			$mail->IsSMTP();  
			$mail->SMTPAuth = true;                // 设置为安全验证方式  
			$mail->Host     = "smtp.sina.com";        // SMTP服务器地址  
			$mail->Username = $_INFO['mail_username'];      // 登录用户名  
			$mail->Password = $_INFo['mail_userpass'];               // 登录密码  
			  
			$mail->From = "pushforalphago@sina.com";        // 发件人地址(username@163.com)  
			$mail->FromName = "pushforalphago";      
		  
			$mail->WordWrap   = 50;  
			$mail->IsHTML(true);            // 是否支持html邮件，true 或false  
					 
			$mail->AddAddress("jxcjxcjzx@sina.com");        //客户邮箱地址  
			//$mail->Subject = "【反馈邮件】";  
			$mail->Subject = "Message from alphago"; 
			$mail->Body    = $notification;  
			if(!$mail->Send()){  			  
			   return  $mail->ErrorInfo;    
			}else{
				return "";
			}  
	}


?>
