<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();
$mail->Encoding = "base64";
$mail->SMTPAuth = true;
$mail->Host = "smtp.zeptomail.in";
$mail->Port = 587;
$mail->Username = "emailapikey";
$mail->Password = 'PHtE6r0PSuy6jGEm8kIHs6TqF8b3MYwo9OxnegYV4oZFDfcHF00Bo4x+wGWxrRx7VqJCEPOYzotg5brK57/Xdmi7YzoYVGqyqK3sx/VYSPOZsbq6x00UsV8Zc0XcVobne9Jv1CTWv9feNA==';
$mail->SMTPSecure = 'TLS';
$mail->isSMTP();
$mail->IsHTML(true);
$mail->CharSet = "UTF-8";
$mail->From = "noreply@datapro.in";
$mail->addAddress('dinesh.dev@colourmoon.com');
$mail->Body = "Test email sent successfully.";
$mail->Subject = "Test Email";
$mail->SMTPDebug = 1;
$mail->Debugoutput = function ($str, $level) {
    echo "debug level $level; message: $str";
    echo "<br>";
};
if (!$mail->Send()) {
    echo "Mail sending failed";
} else {
    echo "Successfully sent";
}
?>