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

    public function sendTicketEmail($ticketData)
    {
        $emailAddress = $ticketData['email'];
        $pdfPath = $ticketData['pdfPath'];

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
            $mail->addAddress($emailAddress);
            $mail->isHTML(true);
            $mail->Subject = 'Your Festival Tickets';
            $mail->Body = 'Dear ' . $ticketData['firstName'] . ', <br><br>Congratulations, you got tickets for the Haarlem Festival! Your tickets are attached to this email as PDF. Please bring them either on your phone or printed out so we can scan them at the Festival.<br> <br><br>We hope you enjoy the event.<br><br>Kind regards,<br>Your Festival Team';

            $mail->addAttachment($pdfPath);

            $mail->send();
            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}