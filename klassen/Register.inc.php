<?php

/**
 * Class registration
 * handles the user registration
 */
class Register
{

    private $link = null;
    public $errors = array();
    public $messages = array();


    public function __construct()
    {

        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }


    private function registerNewUser()
    {
        if (empty($_POST['username'])) {
            $this->errors[] = "Benutztername ist leer";
        } elseif (empty($_POST['password']) || empty($_POST['password_repeat'])) {
            $this->errors[] = "Beide Passwörter müssen ausgefüllt werden";
        } elseif ($_POST['password'] !== $_POST['password_repeat']) {
            $this->errors[] = "Die Passwörter stimmen nicht überein";
        } elseif (strlen($_POST['password']) < 6) {
            $this->errors[] = "Passwort muss mindestens 6 Zeichen lang sein";
        } elseif (strlen($_POST['username']) > 64 || strlen($_POST['username']) < 2) {
            $this->errors[] = "Benutzername muss zwischen 2 und 62 Zeichen lang sein";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])) {
            $this->errors[] = "Benutzername stimmt nicht mit den erlaubten Zeichen überein: a-Z und 2 bis 64";
        } elseif (empty($_POST['email'])) {
            $this->errors[] = "E-Mail-Feld kann nicht leer sein";
        } elseif (strlen($_POST['email']) > 64) {
            $this->errors[] = "Email-Adresse darf nicht mehr als 62 Zeichen beinhalten";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Deine E-Mail-Adresse entspricht nicht den erlaubten Zeichen";
        } elseif (
            !empty($_POST['username'])
            && strlen($_POST['username']) <= 64
            && strlen($_POST['username']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])
            && !empty($_POST['email'])
            && strlen($_POST['email']) <= 64
            && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['password'])
            && !empty($_POST['password_repeat'])
            && ($_POST['password'] === $_POST['password_repeat'])
        ) {
            $this->link = DbFunctions::connectWithDatabase();

            if (!$this->link->set_charset("utf8")) {
                $this->errors[] = $this->link->error;
            }

            if (!$this->link->connect_errno) {

                $username = $this->link->real_escape_string(strip_tags($_POST['username'], ENT_QUOTES));
                $email = $this->link->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
                $password = $this->link->real_escape_string(strip_tags($_POST['password'], ENT_QUOTES));

                $password_hash = password_hash($password, PASSWORD_ARGON2ID);

                $result_of_login_check = DbFunctions::exists2($this->link, $username, $email);

                if ($result_of_login_check->num_rows == 1) {
                    $this->errors[] = "Der Benutzername/E-Mail-Adresse ist bereits vergeben";
                } else {

                    $token = bin2hex(openssl_random_pseudo_bytes(32));

                    $zustand = $this->sendMail($username, $email, $token);

                    if ($zustand) {
                        //deaktivierten account anlegen
                        DbFunctions::createAccount($this->link, $username, $email, $password_hash, $token);
                        $this->messages[] = "Es wurde eine Bestätigungsmail an deine Email Adresse gesendet. Bitte aktiviere mit dieser Mail deinen Account.";
                    } else {
                        $this->messages[] = "Registrierung fehlgeschlagen (Es konnte keine Mail an deine Mailadresse gesendet werden.)";
                    }
                }
            } else {
                $this->errors[] = "Es besteht keine Verbindung zur Datenbank";
            }
        } else {
            $this->errors[] = "Ein unbekannter Fehler ist aufgetreten.";
        }
    }


    private function sendMail($username, $email, $token)
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


        $mail->Subject = ACCOUNT_VALIDATE_SUBJECT;
        $mail->AddAddress($email);

        $accountinfo = "Benutzername: " . $username . "\n" . "E-Mail-Adresse: " . $email;

        $link = ACCOUNT_VALIDATE_URL . '&token=' . urlencode($token) . "\n \n \n";

        $mail->Body = ACCOUNT_VALIDATE_CONTENT . '' . $link . '' . $accountinfo;

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
