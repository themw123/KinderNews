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
}
