<?php

namespace App\service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';
class emailService
{
    public function sendPasswordResetEmail($email, $resetToken){
        $mail = new PHPMailer(true);

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
            $mail->Body = 'Dear User, <br><br>Please click on the following link to reset your password for your Haarlem Festival account:<br> <a href="http://localhost/login/resetPassword?token=' .$resetToken . '&email=' . urlencode($email) . '">Reset Password</a><br><br>If you did not request a password reset, please ignore this email.<br><br>Kind regards,<br>Your Festival Team';

            $mail->send();
            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}