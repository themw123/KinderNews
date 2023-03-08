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

	public static function createAccount($link, $username, $email, $password_hash, $token)
	{
		$stmt = $link->prepare(
			"INSERT INTO benutzer (name, email, passwort_hash, activated, token)
			VALUES(?, ?, ?, 0, ?);"
		);
		$stmt->bind_param("ssss", $username, $email, $password_hash, $token);
		$stmt->execute();
	}

	public static function activateAccount($link, $token)
	{
		$stmt = $link->prepare(
			"UPDATE benutzer set activated=1, token='0' where token=?;"
		);
		$stmt->bind_param("s", $token);
		$stmt->execute();
	}


	public static function exists1($link, $email_or_user)
	{
		$stmt = $link->prepare(
			"SELECT name, email, passwort_hash, activated FROM benutzer WHERE (email = ? or name = ?) and activated = 1;"
		);
		$stmt->bind_param("ss", $email_or_user, $email_or_user);
		$stmt->execute();
		return $stmt->get_result();
	}

	public static function exists2($link, $username, $email)
	{
		$stmt = $link->prepare(
			"SELECT * FROM benutzer WHERE (email = ? or name = ?) and activated = 1;"
		);
		$stmt->bind_param("ss", $email, $username);
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
