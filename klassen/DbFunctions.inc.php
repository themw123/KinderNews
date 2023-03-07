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


	public static function getEmailAndHashByEmail($link, $email)
	{
		$stmt = $link->prepare(
			//"SELECT email, password_hash FROM benutzer WHERE email = ? OR user_email = ?;"
			"SELECT email, passwort_hash FROM benutzer WHERE email = ?;"
		);
		$stmt->bind_param("s", $email);
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
