<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();                                     
    $mail->Host = 'smtp.gmail.com';                    
    $mail->SMTPAuth = true;                              
    $mail->Username = 'gopalakrishnand28@gmail.com';          
    $mail->Password = 'cubdfzsecwsisxwo';              
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
    $mail->Port = 587;                                    

     
    $mail->setFrom('gopalakrishnand28@gmail.com', 'Mailer');   
    $mail->addAddress('abhi655549@gmail.com', 'abhi');  

     
    $mail->isHTML(true);                                   
    $mail->Subject = 'Here is the subject';                 
    $mail->Body    = 'This is the <b>HTML</b> message body'; 
    $mail->AltBody = 'This is the plain text version of the message body'; 
 
    $mail->send();
    echo 'Message has been sent successfully';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
