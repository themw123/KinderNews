<?php

class Login
{

    private $link = null;
    public $errors = array();
    public $messages = array();


    public function __construct()
    {
        //erstelle die session
        session_start();

        if (isset($_GET["logout"])) {
            $this->doLogout();
        } elseif (isset($_POST["login"])) {
            $this->doLogin();
        }

        /*
        // checking if user requested a password reset mail
        if (isset($_POST["request_password_reset"]) && isset($_POST['email'])) {
            $this->setPasswordResetDatabaseTokenAndSendMail($_POST['email']);
        } elseif (isset($_GET["email"]) && isset($_GET["verification_code"])) {
            $this->checkIfEmailVerificationCodeIsValid($_GET["email"], $_GET["verification_code"]);
        } elseif (isset($_POST["submit_new_password"])) {
            $this->editNewPassword($_POST['email'], $_POST['user_password_reset_hash'], $_POST['user_password_new'], $_POST['user_password_repeat']);
        }
		*/
    }


    private function doLogin()
    {

        if (empty($_POST['email_or_user'])) {
            $this->errors[] = "Email bzw. Benutzername darf nicht leer sein";
        } elseif (empty($_POST['password'])) {
            $this->errors[] = "Password darf nicht leer sein";
        } elseif (!empty($_POST['email_or_user']) && !empty($_POST['password'])) {

            //verbindung mit datenbank
            $this->link = DbFunctions::connectWithDatabase();

            if (!$this->link->set_charset("utf8")) {
                $this->errors[] = $this->link->error;
            }

            if (!$this->link->connect_errno) {

                $email_or_user = $this->link->real_escape_string($_POST['email_or_user']);

                $result_of_login_check = DbFunctions::getNameEmailHashByEmailOrUser($this->link, $email_or_user);


                //wenn email existiert
                if ($result_of_login_check->num_rows == 1) {

                    $result_row = $result_of_login_check->fetch_object();

                    //password_verify() um zu gucken ob passwort passt
                    if (!empty($_POST['password']) && password_verify($_POST['password'], $result_row->passwort_hash)) {

                        //schreibe benutzerdaten in die session
                        $_SESSION['name'] = $result_row->name;
                        $_SESSION['email'] = $result_row->email;
                        $_SESSION['user_login_status'] = 1;
                    } else {
                        $this->errors[] = "falsches Passwort";
                    }
                } else {
                    $this->errors[] = "Die Email bzw. der Benutztername existiert nicht";
                }
            } else {
                $this->errors[] = "Problem bei der Verbindung mit der Datenbank";
            }
        }
    }

    public function doLogout()
    {
        // delete the session of the user
        session_unset();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "Du wurdest ausgeloggt";
    }


    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
