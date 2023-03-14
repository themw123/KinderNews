<?php

class DbFunctions
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

	public static function createAccount($link, $username, $email, $password_hash, $token)
	{
		$stmt = $link->prepare(
			"INSERT INTO benutzer (name, email, passwort_hash, admin, activated, token)
			VALUES(?, ?, ?, 0, 0, ?);"
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
		if ($stmt->affected_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public static function setToken($link, $email, $token)
	{
		$stmt = $link->prepare(
			"UPDATE benutzer set token=? where email=?;"
		);
		$stmt->bind_param("ss", $token, $email);
		$stmt->execute();
	}

	public static function resetPassword($link, $password_hash, $token)
	{

		$stmt = $link->prepare(
			"UPDATE benutzer set passwort_hash=? , token='0' where token=?;"
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
		$stmt = $link->prepare(
			"SELECT name, email, passwort_hash, admin, activated FROM benutzer WHERE (email = ? or name = ?) and activated = 1;"
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


	public static function setNewsDb($link, $news, $newsTranslated)
	{

		//alte news holen:
		$stmt = $link->prepare("SELECT id FROM news");
		$stmt->execute();
		$result = $stmt->get_result();
		$ids = $result->fetch_all(MYSQLI_ASSOC);


		//neue news setzten
		$stmt = $link->prepare(
			"INSERT INTO news (originaler_titel , originaler_text, uebersetzter_titel , uebersetzter_text, frage1, frage2, frage3)
			VALUES(?, ?, ?, ?, ?, ?, ?);"
		);
		foreach ($news as $key => $value) {
			$original_title = $value['title'];
			$original_text = $value['text'];

			//nur wenn chatgpt übersetzt hat
			if (isset($newsTranslated[$key]['title'])) {
				$translated_title = $newsTranslated[$key]['title'];
				$translated_text = $newsTranslated[$key]['text'];
				$question1 = $newsTranslated[$key]['question1'];
				$question2 = $newsTranslated[$key]['question2'];
				$question3 = $newsTranslated[$key]['question3'];
			} else {
				$translated_title = "error";
				$translated_text = "error";
				$question1 = "error";
				$question2 = "error";
				$question3 = "error";
				Logs::addMessage("Es konnten nicht alle News übersetzt werden.");
			}
			$stmt->bind_param("sssssss", $original_title, $original_text, $translated_title, $translated_text, $question1, $question2, $question3);
			$stmt->execute();
		}


		//alte news löschen
		if (!empty($ids)) {
			$idList = array_column($ids, 'id');
			$idList = implode(',', $idList);
			$stmt = $link->prepare("DELETE FROM news WHERE id IN ({$idList})");
			$stmt->execute();
		}
	}

	public static function getNewsDb($link)
	{
		$stmt = $link->prepare(
			"Select * from news;"
		);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $result;
	}
}
