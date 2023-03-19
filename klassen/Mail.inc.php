<?php

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    private static $mail;

    private static function basic()
    {
        self::$mail = new PHPMailer();
        //damit Umlaute richtig angezeigt werden
        self::$mail->CharSet = 'utf-8';

        if (EMAIL_USE_SMTP) {
            self::$mail->IsSMTP();
            self::$mail->SMTPAuth = EMAIL_SMTP_AUTH;

            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                self::$mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            self::$mail->Host = EMAIL_SMTP_HOST;
            self::$mail->Username = EMAIL_SMTP_USERNAME;
            self::$mail->Password = EMAIL_SMTP_PASSWORD;
            self::$mail->Port = EMAIL_SMTP_PORT;
        } else {
            self::$mail->IsMail();
        }

        self::$mail->From = EMAIL_SMTP_FROM_EMAIL;
        self::$mail->FromName = EMAIL_SMTP_FROM_NAME;
    }

    public static function sendMailRegister($username, $email, $token)
    {
        self::basic();

        self::$mail->Subject = ACCOUNT_CONFIRM_SUBJECT;
        self::$mail->AddAddress($email);

        $accountinfo = "Benutzername: " . $username . "\n" . "E-Mail-Adresse: " . $email;

        $link = ACCOUNT_CONFIRM_URL . '&token=' . urlencode($token) . "\n \n \n";

        self::$mail->Body = ACCOUNT_CONFIRM_CONTENT . '' . $link . '' . $accountinfo;

        if (!self::$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }


    public static function sendMailReset($email, $token)
    {


        self::basic();

        self::$mail->Subject = ACCOUNT_RESETMAIL_SUBJECT;
        self::$mail->AddAddress($email);

        $accountinfo = "E-Mail-Adresse: " . $email;

        $link = ACCOUNT_RESETMAIL_URL . '&token=' . urlencode($token) . "\n \n \n";

        self::$mail->Body = ACCOUNT_RESETMAIL_CONTENT . '' . $link . '' . $accountinfo;


        if (!self::$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }
}
