<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
/**
  * Email authentication via PHPMailer
  * 
  * @author Siraj Mhanna
  *
  * @param string $fromName
  * @param string $email
  * @param string $subject
  * @param string $body
  * @return Response.
  */
function phpMailer($fromName, $email, $subject, $body)
{
    $mail = new PHPMailer();
    $mail->SMTPSecure = 'tls';
    $mail->Username = "sirajmhanna@hotmail.com"; //jupiterlebanon@hotmail.com
    $mail->Password = "-_-";
    $mail->AddAddress($email);
    $mail->FromName = $fromName;
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->Host = "smtp.live.com";
    $mail->Port = 587;
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->From = $mail->Username;
    if (!$mail->Send()) {
        echo "Error sending: " . $mail->ErrorInfo;
    }
}
