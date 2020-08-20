<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  
class MailService
{    
    
    public function __construct() {}
    
    public function send($subject, $body, $to, $bcc = null) {

        $mail = new PHPMailer(true);

        try {

            // $mail->SMTPDebug = 3;
            $mail->isSMTP();   
            $mail->CharSet = 'UTF-8';
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;        
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');
            $mail->setFrom(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));

            if (is_array($to)) {
                foreach($to as $email) {
                    $mail->addAddress($email);
                }
            }
            else
                $mail->addAddress($to);

            if(!empty($bcc)) {

                if (is_array($bcc)) {
                    foreach($bcc as $email) {
                        $mail->addBcc($email);
                    }    
                }
                else
                    $mail->addBcc($bcc);

            }

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;            

            $mail->send();
            
        } catch (Exception $e) {            
            return false;
        }

        return true;

    }
    
}