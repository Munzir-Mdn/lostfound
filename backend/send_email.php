<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

function sendNotification($to, $subject, $messageHtml) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'teamwp833@gmail.com'; // Ganti dengan Gmail anda
        $mail->Password   = 'neza zeqs ufqq qcuo';   // Ganti dengan App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('teamwp833@gmail.com', 'Lost & Found System');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $messageHtml;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
