<?php 

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    private $mail;

    public function __construct(){
        $this->mail = new PHPMailer(true);
        if(DEBUG){
            $this->mail->isSMTP();                                     
        }                              
        $this->mail->Host = MAIL_HOST;  
        $this->mail->SMTPAuth = true;                                   
        $this->mail->Username = MAIL_USERNAME;                   
        $this->mail->Password = MAIL_PASSWORD;                         
        $this->mail->SMTPSecure = MAIL_ENCRYPTION;                                 
        $this->mail->Port = MAIL_PORT;                                  
        $this->mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
    }

    public static function send($to, $subject, $html, $content, $filename) {
        $instance = new Self();
        try {
            $instance->mail->CharSet = 'UTF-8';
            $instance->mail->addAddress($to);
            // $instance->mail->addAttachment($file);
            $instance->mail->addStringAttachment($content, $filename);
            $instance->mail->isHTML(true);
            $instance->mail->Subject = $subject;
            $instance->mail->Body    = $html;
            $instance->mail->AltBody = '';

            $instance->mail->send();
        } catch (Exception $e) {
            // if(DEBUG) { 
            //     exit("Message could not be sent. Mailer Error: {$instance->mail->ErrorInfo}");
            // }
        }
    }
}

