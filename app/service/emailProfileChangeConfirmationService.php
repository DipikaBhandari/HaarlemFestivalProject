<?php

namespace App\service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';
class emailProfileChangeConfirmationService
{
    public function sendAccountUpdateEmail($email){
        $mail = new PHPMailer(true);

        $mail->SMTPDebug = 3;
        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'haarlem.festival2024@gmail.com';
            $mail->Password = 'olineyaoabmzziuj';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;


            $mail->setFrom('haarlem.festival2024@gmail.com', 'Haarlem Festival');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset for Haarlem Festival Account';
            $mail->Body = 'Dear User, <br><br> Changes to your account have been done successfully<br>
            <br> If you did not make the changes please contact immediately.<br>
            <br>Kind regards,
            <br>Your Festival Team';
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

        }

    }
}
