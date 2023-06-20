<?php

class DBUser
{


    public static function getUsers($link)
    {
        //alle benutzer aus der db holen
        $stmt = $link->prepare(
            "Select * from benutzer"
        );
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public static function changeRole($link, $id, $admin)
    {
        //rolle eines benutzers ändern
        $stmt = $link->prepare(
            "UPDATE benutzer set admin=? where id=?;"
        );
        $stmt->bind_param("ii", $admin, $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getNameById($link, $id)
    {
        //name eines benutzers anhand der id holen
        $stmt = $link->prepare(
            "SELECT name FROM benutzer WHERE id = ?;"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $name = $stmt->get_result()->fetch_assoc()["name"];
        return $name;
    }
    public static function getIdByName($link, $name)
    {
        //id eines benutzers anhand des namens holen
        $stmt = $link->prepare(
            "SELECT id FROM benutzer WHERE name = ?;"
        );
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $name = $stmt->get_result()->fetch_assoc()["id"];
        return $name;
    }

    public static function createAccount($link, $username, $email, $password_hash, $token)
    {
        //neuen benutzer in die db eintragen
        //standardmäßig kein admin und nicht aktiviert
        $stmt = $link->prepare(
            "INSERT INTO benutzer (name, email, passwort_hash, admin, activated, token)
			VALUES(?, ?, ?, 0, 0, ?);"
        );
        $stmt->bind_param("ssss", $username, $email, $password_hash, $token);
        $stmt->execute();
    }

    public static function activateAccount($link, $token)
    {
        //benutzer aktivieren mittels token
        $stmt = $link->prepare(
            "UPDATE benutzer set activated=1, token='0' where token=?;"
        );
        $stmt->bind_param("s", $token);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function setToken($link, $email, $token, $token_uhrzeit)
    {
        //token setzen wenn password reset angefordert wurde
        $stmt = $link->prepare(
            "UPDATE benutzer set token=?, token_uhrzeit=? where email=?;"
        );
        $stmt->bind_param("sss", $token, $token_uhrzeit, $email);
        $stmt->execute();
    }

    public static function getTokenTime($link, $token)
    {
        //zeitpunkt des tokens holen
        $stmt = $link->prepare(
            "SELECT token_uhrzeit FROM benutzer WHERE token = ?;"
        );
        $stmt->bind_param("s", $token);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()["token_uhrzeit"];;
    }

    public static function resetPassword($link, $password_hash, $token)
    {
        //passwort zurücksetzen
        $stmt = $link->prepare(
            "UPDATE benutzer set passwort_hash=? , token='0', token_uhrzeit=null where token=?;"
        );
        $stmt->bind_param("ss", $password_hash, $token);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function exists1($link, $email_or_user)
    {
        //prüfen ob benutzer mit namen x bzw email x existiert und auch aktiviert ist
        $stmt = $link->prepare(
            "SELECT * FROM benutzer WHERE (email = ? or name = ?) and activated = 1;"
        );
        $stmt->bind_param("ss", $email_or_user, $email_or_user);
        $stmt->execute();
        return $stmt->get_result();
    }

    public static function exists2($link, $username, $email)
    {
        //prüfen ob benutzer mit namen x bzw email x existiert
        $stmt = $link->prepare(
            "SELECT * FROM benutzer WHERE (email = ? or name = ?);"
        );
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        return $stmt->get_result();
    }
}
