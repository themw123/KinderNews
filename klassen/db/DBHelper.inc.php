<?php

class DBHelper
{

	public static function connectWithDatabase()
	{
		$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$query = "use kindernews";
		self::executeQuery($link, $query);
		return $link;
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
		return mysqli_real_escape_string($link, htmlentities(addslashes($value), ENT_QUOTES));
	}
}
