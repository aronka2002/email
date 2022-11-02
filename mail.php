<?php

require("send_email.php");




$email = $_GET['email'];
$cc = $_GET['cc'];
$cc1 = $_GET['cc1'];
$cc2 = $_GET['cc2'];
$bcc = $_GET['bcc'];
$bcc1 = $_GET['bcc1'];
$bcc2 = $_GET['bcc2'];
$subject = $_GET['subject'];
$message = $_GET['message'];

$cc_array = array($cc,$cc1,$cc2);
$bcc_array = array($bcc,$bcc1,$bcc2);

foreach ($cc_array as $value) {
    if($value == null){
        $value = "test@gmail.com";
    }
}

foreach ($bcc_array as $value) {
    if($value == null){
        $value = "test@gmail.com";
    }
}


$result = sendMailv2($email,$message,$subject,false,$cc_array,true,$bcc_array,false);

if ($result == true) 
{
    header("Location:index.php?flag=1");
} 
else
{
    header("Location:index.php?flag=0");
}
  
?>





