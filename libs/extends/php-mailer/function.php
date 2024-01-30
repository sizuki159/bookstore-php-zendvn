<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/vendor/autoload.php";

function sendEmail($emailTo, $mailTitle, $mailContent, $fileName = null, $tmp_name = null)
{
	//PHPMailer Object
	$mail = new PHPMailer(true); //Argument true in constructor enables exceptions

	//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
	$mail->isSMTP();                                            // Send using SMTP
	$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	$mail->Username   = 'clonebytrung@gmail.com';                     // SMTP username
	$mail->Password   = 'nhcdpolzdalwhhit';                               // SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	$mail->Port       = 587;

	//From email address and name
	$mail->setFrom('clonebytrung@gmail.com', 'Nguyen Thanh Trung');
	$mail->addAddress($emailTo);     // Add a recipient

	if ($fileName != null) {
		//$mail->addAttachment($tmp_name, $fileName);
		$mail->addAttachment($fileName);
	}

	//Send HTML or Plain Text email
	$mail->isHTML(true);

	$mail->Subject = $mailTitle;
	$mail->Body = $mailContent;

	try {
		$mail->send();
		return true;
	} catch (Exception $e) {
		return false;
	}
}
