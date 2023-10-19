<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';

function sendemailsmtp($to="",$msg="",$subject=""){

//    $to = "shahabsafdar01@gmail.com";
//    $msg = "this is message";
//    $subject = "this is subject";

    $mail = new PHPMailer(true);
    try {

//        $mail->SMTPDebug = SMTP::DEBUG_SERVER;               // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        // $mail->Username   = 'info@jobsunlocked.com';                     // SMTP username
        // $mail->Password   = 'Hostinger123!';                               // SMTP password
        $mail->Username   = 'info@buildela.com';                     // SMTP username
        $mail->Password   = 'AirMax15!';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;
        // $mail->Port       = 587;

        $mail->CharSet = 'UTF-8';

        $mail->setFrom('info@buildela.com', 'Buildela.com');
        //Recipients
        $mail->addAddress($to);     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to
        $mail->Subject = $subject;
        $mail->Body    = $msg;

        $mail->send();
//
//        if($mail->send()){
//            echo "Sent";
//        }else{
//            echo "not sent";
//        }


    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


}

//sendemailsmtp();


?>