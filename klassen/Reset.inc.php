<?php

/**
 * Class registration
 * handles the user registration
 */
class Reset
{

    private $link = null;
    public $errors = array();
    public $messages = array();


    public function __construct()
    {

        if (isset($_POST["resetMail"])) {
            $this->sendPasswordResetMail();
        }
    }

    private function sendPasswordResetMail()
    {

        if (empty($_POST['email'])) {
            $this->errors[] = "Benutzername bzw. Email darf nicht leer sein";
        } else {

            $this->link = DbFunctions::connectWithDatabase();

            if (!$this->link->set_charset("utf8")) {
                $this->errors[] = $this->link->error;
            }

            if (!$this->link->connect_errno) {

                $email = $this->link->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));

                $result_of_login_check = DbFunctions::exists1($this->link, $email);



                if ($result_of_login_check->num_rows == 0) {
                    $this->errors[] = "Der Benutzername/E-Mail-Adresse existiert nicht";
                } else {

                    $token = bin2hex(openssl_random_pseudo_bytes(32));

                    $zustand = $this->sendMail($email, $token);

                    if ($zustand) {

                        //Token dem Benutzer hinzufügen
                        DbFunctions::setToken($this->link, $email, $token);


                        $this->messages[] = "Es wurde eine Mail zum zurücksetzten deines Passwortes an deine Email Adresse gesendet.";
                    } else {
                        $this->messages[] = "Mail senden fehlgeschlagen";
                    }
                }
            } else {
                $this->errors[] = "Es besteht keine Verbindung zur Datenbank";
            }
        }
    }


    private function sendMail($email, $token)
    {
        $mail = new PHPMailer;

        //damit Umlaute richtig angezeigt werden
        $mail->CharSet = 'utf-8';

        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_SMTP) {
            // Set mailer to use SMTP
            $mail->IsSMTP();
            //useful for debugging, shows full SMTP errors
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            // Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
            // Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {
            $mail->IsMail();
        }

        $mail->From = EMAIL_SMTP_FROM_EMAIL;
        $mail->FromName = EMAIL_SMTP_FROM_NAME;


        $mail->Subject = ACCOUNT_RESETMAIL_SUBJECT;
        $mail->AddAddress($email);



        $accountinfo = "E-Mail-Adresse: " . $email;

        $link = ACCOUNT_RESETMAIL_URL . '&token=' . urlencode($token) . "\n \n \n";

        $mail->Body = ACCOUNT_RESETMAIL_CONTENT . '' . $link . '' . $accountinfo;


        if (!$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
