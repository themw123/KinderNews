<?php

class DBHelper
{

	public static function connectWithDatabase()
	{
		try {
			$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			$query = "use " . DB_NAME;
			self::executeQuery($link, $query);
			return $link;
		} catch (mysqli_sql_exception $e) {
			echo "Verbindungsfehler: " . $e->getMessage();
		}
	}

	public static function executeQuery($link, $query)
	{
		$result = mysqli_query($link, $query);
		if ($result === false) {
			return null;
		}
		return $result;
	}

	public static function escape($link, $value)
	{
		//return mysqli_real_escape_string($link, htmlspecialchars(strip_tags(addslashes($value)), ENT_QUOTES));
		//alle relevanten Sicherheitsmaßnahmen, um die Variablen die vom Benutzer stammen abzusichern
		return mysqli_real_escape_string($link, htmlentities(addslashes($value), ENT_QUOTES));
	}
}
