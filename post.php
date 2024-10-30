<?php
require_once("../../../wp-config.php");
require_once("contact-tab.php");
extract($options);

function ct_sendmail($admin_email, $cc_email, $subject) {
$to = $admin_email.',';
$to .= $cc_email;
$subject= $subject;
$from = $admin_email;
$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$body = "Name: {$_REQUEST['ct_name']}\n".
"Email: {$_REQUEST['ct_email']} \n\n".
"Message: \n ".
"{$_REQUEST['ct_message']}\n\n".
"IP: $ip\n\n".
"Sent from: {$_REQUEST['ct_pageurl']}\n";
$headers = "From: $admin_email \r\n";
$headers .= "Reply-To: {$_REQUEST['ct_email']} \r\n";
//$headers .= "Bcc: $cc_email \r\n";
$headers .= "Cc: $cc_email \r\n";
if(!empty($_REQUEST['ct_name']) || !empty($_REQUEST['ct_email']) || !empty($_REQUEST['ct_message']))
                wp_mail($to, $subject, $body,$headers);

}

if ($captcha == 'yes') {
ob_start();
session_start();
	if(strtolower($_REQUEST['ct_code']) == strtolower($_SESSION['6_letters_code']))
	{
		
		
		echo '1'; //valid code
 		//send the email
		ct_sendmail($admin_email, $cc_email, $subject);
		
	}
	else
	{
		echo '0'; // invalid code
	}
}

else {
if(!empty($_REQUEST['ct_name']) || !empty($_REQUEST['ct_email']) || !empty($_REQUEST['ct_message'])){
echo '1';
//send the email
ct_sendmail($admin_email, $cc_email, $subject);
	}
}
	?>
