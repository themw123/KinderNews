<?php

class Login
{

    private $link = null;
    private $security = null;

    public function __construct($link, $security)
    {
        $this->link = $link;
        $this->security = $security;

        //erstelle die session
        session_start();
        //session die 30 Tage anhält und somit auch nach erneuten öffnen des Browsers noch gültig ist
        /*$cookie_lifetime = 30 * 24 * 60 * 60; // 30 Tage
        session_set_cookie_params($cookie_lifetime);
        setcookie(session_name(), session_id(), time() + $cookie_lifetime);*/

        if (isset($_GET["logout"]) && !isset($_SESSION["loggedOutBefore"])) {
            $this->doLogout();
        } elseif (isset($_POST["login"])) {
            if ($this->security->checkLoginAttempts()) {
                $this->doLogin();
                //auf index.php umleiten, damit index.php erneut geladen wird nur diesmal als get und nicht post.
                //sonnst wird beim ersten mal neuladen von index.php bzw der news template ein fehler angezeigt
                //falls zuvor logout gemacht wurde url umschreiben sonnst direkt nach login logout
                $ziel = $_SERVER['REQUEST_URI'];
                if (strstr($ziel, '?logout')) {
                    $ziel = ROOT_DOMAIN . "/?news";
                }
                //$ziel_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $ziel;
                header("Location: " . $ziel);
            }
        }
    }


    private function doLogin()
    {

        if (empty($_POST['email_or_user'])) {
            Logs::addError("Email bzw. Benutzername darf nicht leer sein");
        } elseif (empty($_POST['password'])) {
            Logs::addError("Password darf nicht leer sein");
        } else {

            if (!$this->link->set_charset("utf8")) {
                Logs::addError($this->link->error);
            }

            if (!$this->link->connect_errno) {

                $email_or_user = Dbfunctions::escape($this->link, $_POST['email_or_user']);

                $result_of_login_check = DbFunctions::exists1($this->link, $email_or_user);


                //wenn email existiert
                if ($result_of_login_check->num_rows == 1) {

                    $result_row = $result_of_login_check->fetch_object();

                    //password_verify() um zu gucken ob passwort passt
                    if (!empty($_POST['password']) && password_verify($_POST['password'], $result_row->passwort_hash)) {

                        //login versuche zurücksetzten
                        $this->security->deleteLoginAttempts();

                        //schreibe benutzerdaten in die session                 
                        unset($_SESSION['loggedOutBefore']);
                        $_SESSION['id'] = $result_row->id;
                        $_SESSION['name'] = $result_row->name;
                        $_SESSION['email'] = $result_row->email;
                        $_SESSION['admin'] = $result_row->admin;
                        $_SESSION['user_login_status'] = 1;
                    } else {
                        //login versuche hochzählen
                        $this->security->setLoginAttempts();
                        Logs::addError("falsches Passwort");
                    }
                } else {
                    Logs::addError("Die Email bzw. der Benutztername existiert nicht");
                }
            } else {
                Logs::addError("Problem bei der Verbindung mit der Datenbank");
            }
        }
    }

    public function doLogout()
    {
        // delete the session of the user
        session_unset();
        //session_destroy();
        $_SESSION["loggedOutBefore"] = true;

        // return a little feeedback message
        Logs::addMessage("Du wurdest ausgeloggt");
    }


    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }
    public function isUserAdmin()
    {
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            return true;
        }
        return false;
    }
    public function isUserKindernews()
    {
        if (isset($_SESSION['name']) && $_SESSION['name'] == "kindernews") {
            return true;
        }
        return false;
    }
}
