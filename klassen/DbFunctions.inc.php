<?php

class DbFunctions
{

	public static function connectWithDatabase()
	{
		$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$query = "use benutzer";
		self::executeQuery($link, $query);
		return $link;
	}

	public static function useDatabase($link, $database)
	{
		$query = "use " . $database;
		self::executeQuery($link, $query);
		return $link;
	}


	public static function getEmailAndHashByEmailOrUser($link, $email_or_user)
	{
		$stmt = $link->prepare(
			"SELECT email, passwort_hash FROM benutzer WHERE email = ? or name = ?;"
		);
		$stmt->bind_param("ss", $email_or_user, $email_or_user);
		$stmt->execute();
		return $stmt->get_result();
	}











	public static function executeQuery($link, $query)
	{
		$result = mysqli_query($link, $query);
		if ($result === false) {
			return null;
		}
		return $result;
	}

	public static function escape($link, $str)
	{
		if (ini_get('magic_quotes_gpc')) {
			$str = stripslashes($str);
		}
		return mysqli_real_escape_string($link, $str);
	}

	public static function getFirstFieldOfResult($link, $query)
	{
		$result = self::executeQuery($link, $query);
		if (mysqli_num_rows($result) == 0) {
			return null;
		}
		$row = mysqli_fetch_row($result);
		mysqli_free_result($result);
		return ($row[0]);
	}
}
