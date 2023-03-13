<?php


class Logs
{

    private static $errors = array();
    private static $messages = array();


    public static function addError($error)
    {
        self::$errors[] = $error;
    }
    public static function addMessage($message)
    {
        self::$messages[] = $message;
    }

    public static function getErrors()
    {
        return self::$errors;
    }

    public static function getMessages()
    {
        return self::$messages;
    }

    public static function jsonLogs()
    {
        $art = null;
        $text = null;
        $json_response = null;

        if (self::$errors != null || self::$messages != null) {
            if (self::$errors != null) {
                $art = "error";
                foreach (self::$errors as $error) {
                    $text = $text . $error;
                }
            } else if (self::$messages != null) {
                $art = "message";
                foreach (self::$messages as $message) {
                    $text = $text . $message;
                }
            }
            $response = array(
                "art" => $art,
                "text" => $text
            );
            $json_response = json_encode($response);
        }

        echo $json_response;
        //wichtig, da sonnst über index.php gegangen wird und der zusätztlich zur response das html drangehangen wird
        die();
    }
}
