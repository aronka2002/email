<?php
/*
ver 1.0  - initial

ver 1.1 23Aug20  Anil
	- cosmetic changes
ver 1.2 23Aug20  Anil
	- added delayed email
ver 1.3 23Aug20  Anil
	- bug fix email id was not set correctly for delayed emails
ver 1.4 3MAR21 Anil
	- routed all to sendV2email
ver 1.5  21Oct21 - Anil
   - proper handling of add to, addcc and add bcc
ver 1.6 25May2022 Angitha
	- included mailer files
	- set $fast_send=true
*Ver 1.7 04Jun2022 - Angitha
*        - changed array compactable to ver 8.
*ver 1.8 12july2022-Navya
         -add email to mailer
*ver 1.9 30Aug2022-Annmariya
         -added send_bcc for send mail using bcc

*/
require_once("Config/send_email_config.php");
define("HOST_MAILER_MAIL_ID",$mail_username);
define("HOST_MAILER_MAIL_PASSWORD",$mail_password);
define("HOST_APP_NAME",$host_app_name);
define("HOST_MAILER_REPLY_ID",$mail_replay_email);
define("MAILER_HOST",$smtp_host);

include(dirname(__FILE__)."/../PHPMailer-master/src/PHPMailer.php");
include(dirname(__FILE__)."/../PHPMailer-master/src/SMTP.php");
include(dirname(__FILE__)."/../PHPMailer-master/src/Exception.php");
//if (!class_exists('simple_db')){include(dirname(__FILE__)."/../Common/simple_db.php");}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


/* for testing */
//send_email("saaasacool@gmail.com","","test - 1","test message",true);
//send_email("saaasacool@gmail.com","","test","test message");
//send_email("saaasacool@gmail.com","anil.mathews@gmail.com","test","test message",true);
//send_email("saaasacool@gmail.com","anil.mathews@gmail.com","test","test message");
// Format - sendMailv2($email,$message,$subject,$attach = false,$send_cc=false,$fast_send=false)
//sendMailv2("saaasacool@gmail.com","Test Message","Test Subject sendMailv2",false,false,true);
//sendMailv2("saaasacool@gmail.com","Test Message","Test Subject sendMailv2",false,false);
//sendMailv2("saaasacool@gmail.com","Test Message","Test Subject sendMailv2",false,"anil.mathews@gmail.com",true);
//sendMailv2("saaasacool@gmail.com","Test Message","Test Subject sendMailv2",false,"anil.mathews@gmail.com");

 


/* this function is kep for backward compatibility. This will route through sendMailv2 */
function send_email($send_to,$send_cc,$subject,$message,$fast_send=true)
{

	
    $return_status = 0;
	
	/* check if the to email is valid */
   foreach ($send_to as $each_email)
   {
      if (!filter_var($each_email, FILTER_VALIDATE_EMAIL)) 
	{
	  $return_status = 1;
	  echo "email address not valid";
	  return $return_status;
	}
   }
	/* if cc address is not valid then dont use it */
   foreach ($send_cc as $each_email)
   {
      if (!filter_var($each_email, FILTER_VALIDATE_EMAIL)) 
	{
	  $send_cc = ""; 
	}
   }      
	
	
	/* while in localhost  enable this */
    // $actual_email = " to = $send_to" . "<br> cc = " .$send_cc;
    // $send_to = "pro910marketing@gmail.com";
    // $send_cc = "pro910marketing@gmail.com";
    // $message = $message . "<br> Actual Email <br> $actual_email";		
    
   
	if($fast_send == false)
	{
		/* Not a fast sendinng. update cron table and exit*/		
		$obj  = new simple_db;		
		if($send_cc)
		{
			$data1=array
			(
				'email_to'   =>serialize($send_to),			
				'email_cc'   =>serialize($send_cc),
				//email_bcc
				'email_sub'  =>$subject,
				'email_msg'  =>$message
			);				
		}
		else
		{
			$data1=array
			(
				'email_to'   =>serialize($send_to),			
				'email_sub'  =>$subject,
				'email_msg'  =>$message
			);	
			
		}		
		$data=$obj->inserttbl($data1,"tbl_cron_email");	
		//die();
	}
    else  //send the email immediatly
	{
		//sendMailv2($email,$message,$subject,$attach = false,$send_cc=false,$fast_send=true);
		// TODO Testing
		//$send_to = "";
		//$send_cc = "";
        sendMailv2($send_to,$message,$subject,false,$send_cc,$fast_send,false);		
	}
   return $return_status;
}
/*
  Function: sendMailv2
  objective: send mail to the selected email with attachments
             delayed sending will not send the attachement  
  
  usage: 
$attachments = [
   [//file1
      "file"=>"/path/to/file",
      "title"=>"Title of the file",
   ],
   [//file2
      "file"=>"/path/to/file",
      "title"=>"Title of the file",
   ],
   [//file3
      "file"=>"/path/to/file",
      "title"=>"Title of the file",
   ]
];
*/
function sendMailv2($email,$message,$subject,$attach = false,$send_cc=false,$fast_send=true,$send_bcc=false,$debug=false)
{

	$bcc = $send_bcc;

	if($debug==true){
	/* while in localcal enable this */
	 $actual_email = " to = ".explode(",",$email). "<br> cc = " .explode(",",$send_cc). "<br> Bcc = " .explode(",",$send_bcc);
	 $email = "assist@computervalley.online";
	 $send_cc="merin@computervalley.online";
	 $message = $message . "<br> Actual Email <br> $actual_email";
	}
	if($fast_send == false)
	{
		$email_array = explode(",",$send_bcc);
		/* delayed sending. update cron table and exit*/		
		$obj  = new simple_db;		
		if($send_cc)
		{
			$data1=array
			(
				'email_to'   =>serialize($email),			
				'email_cc'   =>serialize($send_cc),
				//email_bcc
				'email_sub'  =>$subject,
				'email_msg'  =>$message
			);				
		}
		elseif($send_bcc){
			$data1=array
			(
				'email_to'   =>$email,			
				//'email_cc'   =>$send_cc,
				'email_bcc'   =>$send_bcc,
				'email_sub'  =>$subject,
				'email_msg'  =>$message
			);	
		}
		else
		{
			$data1=array
			(
				'email_to'   =>serialize($email),			
				'email_sub'  =>$subject,
				'email_msg'  =>$message
			);			
		}		
		$data=$obj->inserttbl($data1,"tbl_cron_email");	
	}
	else
	{	


		/* send the email immediately */
		$mail = new PHPMailer(true);

		try{
			
			$mail->IsSMTP();
			$mail->SMTPDebug  = 0;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = "tls";
			$mail->Host       = "smtp.gmail.com";
			$mail->Port       = 587;
         /* add each email */

		 if(is_array($email))	
		 {
			foreach ($email as $each_email)
            {
               $mail->AddAddress($each_email);
               //echo "<br> to each email =  $each_email";
            }
		 }
         else if($email)
         {            
            $email_array = explode(",",$email);
            foreach ($email_array as $each_email)
            {
               $mail->AddAddress($each_email);
               //echo "<br> to each email =  $each_email";
            }
         }
			
			/* add cc if not empty */
			if(is_array($send_cc))	
			{
				foreach ($send_cc as $each_email)
				{
				$mail->AddCC($each_email);
				//echo "<br> to each email =  $each_email";
				}
			}
			else if($send_cc!='')
			{
            $email_array = explode(",",$send_cc);
            foreach ($email_array as $each_email)
            {
               $mail->AddCC($each_email);
               //echo "<br> cc each email =  $each_email";
			}	
			}	         

			/* add bcc if not empty */
		 if(is_array($bcc))	
			{
				foreach ($bcc as $each_email)
				{
				$mail->AddBCC($each_email);
				//echo "<br> to each email =  $each_email";
				}
			}
			else if($bcc!='')
			{
            $email_array = explode(",",$bcc);
            foreach ($email_array as $each_email)
            {
               $mail->AddBCC($each_email);
               //echo "<br> bcc each email =  $each_email";
            }  
			}	
			$mail->Username   = HOST_MAILER_MAIL_ID;
			$mail->Password   = HOST_MAILER_MAIL_PASSWORD;
			$mail->SetFrom(HOST_MAILER_MAIL_ID,HOST_APP_NAME);
			$mail->AddReplyTo(HOST_MAILER_REPLY_ID,HOST_APP_NAME);
			//$mail->addCustomHeader('X-custom-header',$headers);
			$mail->Subject    = $subject;
         /* if message is empty just add a space, else email may not go*/
         if(!$message)
         {
            $message = " ";
         }
			$mail->Body       = $message;
			$mail->IsHTML(true);
			
			//attach files
			//echo "am i here";
			if(is_array($attach))
			{
				foreach ($attach as $fileItem){
					$fileName = "";
					$fileTitle = "";
					if(is_array($fileItem)){
						if(array_key_exists("file",$fileItem))
						{
							$fileName = $fileItem['file'];
						}
						if(array_key_exists("title",$fileItem))
						{
							$fileTitle = $fileItem['title'];
						}

						if(!!$fileName && !!$fileTitle)
						{
							if(!$mail->AddAttachment($fileName))
							{
							   return false;
							}
						}
					}
				}
			}
			if($mail->Send())
			{

				return true;
			}
			else
			{
				return false;
			}
		}
		catch(Exception $ex)
		{
			//$er=new ErrorMsg('EMAILER');
			//$this->lastError=$er->toString($ex->getMessage());
			//echo $msg=$ex->getMessage();
				
		}
	} /* end of send immediately */
	

} /* end of function */
 

?>