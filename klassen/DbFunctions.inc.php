<?php

class DbFunctions
{

	public static function connectWithDatabase()
	{
		$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$query = "use wiInf_kindernews";
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
		return mysqli_real_escape_string($link, htmlspecialchars(strip_tags(addslashes($value)), ENT_QUOTES));
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

	public static function setToken($link, $email, $token, $token_uhrzeit)
	{
		$stmt = $link->prepare(
			"UPDATE benutzer set token=?, token_uhrzeit=? where email=?;"
		);
		$stmt->bind_param("sss", $token, $token_uhrzeit, $email);
		$stmt->execute();
	}

	public static function getTokenTime($link, $token)
	{
		$stmt = $link->prepare(
			"SELECT token_uhrzeit FROM benutzer WHERE token = ?;"
		);
		$stmt->bind_param("s", $token);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc()["token_uhrzeit"];;
	}

	public static function resetPassword($link, $password_hash, $token)
	{
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
		$stmt = $link->prepare(
			"SELECT * FROM benutzer WHERE (email = ? or name = ?) and activated = 1;"
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

		//neue news setzten
		$stmt = $link->prepare(
			"INSERT INTO news (originaler_titel , originaler_text, uebersetzter_titel , uebersetzter_text, uebersetzte_preview, frage1, frage2, frage3, answer1 , answer2, answer3, bild_url, quelle, date)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);"
		);

		foreach ($newsTranslated as $key => $value) {
			//nur die übersetzten news in die db schreiben
			if ($value['title'] == "error") {
				continue;
			}
			$original_title = $news[$key]['title'];
			$original_text = $news[$key]['text'];
			$image_url = $news[$key]['image'];
			$source = $news[$key]['source'];
			$date = $news[$key]['date'];

			$translated_title = $value['title'];
			$translated_text = $value['text'];
			$translated_preview = $value['preview'];
			$question1 = $value['question1'];
			$question2 = $value['question2'];
			$question3 = $value['question3'];
			$answer1 = $value['answer1'];
			$answer2 = $value['answer2'];
			$answer3 = $value['answer3'];

			$stmt->bind_param("ssssssssssssss", $original_title, $original_text, $translated_title, $translated_text, $translated_preview, $question1, $question2, $question3, $answer1, $answer2, $answer3, $image_url, $source, $date);
			$stmt->execute();
		}
	}

	public static function getNewsDb($link)
	{
		$stmt = $link->prepare(
			"Select * from news order by date desc LIMIT 100;"
		);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $result;
	}

	public static function getAllLikesDb($link)
	{
		$stmt = $link->prepare(
			"Select * from bewertung;"
		);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $result;
	}

	public static function getNewsArticleDb($link, $id)
	{
		$stmt = $link->prepare(
			"Select * from news where id = " . $id
		);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_assoc();
		return $result;
	}
	
	public static function getFavourites($link){
	    $user_id = $_SESSION['id'];
	    $stmt = $link->prepare(
	        "SELECT n.*
            FROM news n
            JOIN bewertung b ON n.id = b.news_id
            WHERE b.benutzter_id = ".$user_id
	        );
	    $stmt->execute();
	    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	    return $result;
	}

	public static function like($link, $news_id)
	{
		$user_id = $_SESSION['id'];
		$stmt = $link->prepare(
			"INSERT INTO bewertung (news_id, benutzter_id)
			VALUES(?, ?);"
		);
		$stmt->bind_param("ii", $news_id, $user_id);
		$stmt->execute();
	}

	public static function removeLike($link, $news_id)
	{
		$user_id = $_SESSION['id'];
		$stmt = $link->prepare(
			"DELETE FROM bewertung WHERE news_id = ? and benutzter_id = ?;"
		);
		$stmt->bind_param("ii", $news_id, $user_id);
		$stmt->execute();
	}

	public static function checkLike($link, $news_id)
	{
		$user_id = $_SESSION['id'];
		$stmt = $link->prepare(
			"SELECT count(*) as count FROM bewertung WHERE news_id = ? and benutzter_id = ?;"
		);
		$stmt->bind_param("ii", $news_id, $user_id);
		$stmt->execute();
		$count = $stmt->get_result()->fetch_assoc()["count"];
		if ($count == 0) {
			return false;
		} else {
			return true;
		}
	}

	public static function countLikes($link, $news_id)
	{
		$stmt = $link->prepare(
			"SELECT count(*) as count FROM bewertung WHERE news_id = ?;"
		);
		$stmt->bind_param("i", $news_id);
		$stmt->execute();
		$count = $stmt->get_result()->fetch_assoc()["count"];
		return $count;
	}


	public static function getLoginAttemptsAll($link, $ip_address)
	{
		$stmt = $link->prepare(
			"select count(*) as count from loginlogs where ipadresse= ?"
		);
		$stmt->bind_param("s", $ip_address);
		$stmt->execute();
		$count = $stmt->get_result()->fetch_assoc()["count"];
		return $count;
	}

	public static function getLoginAttempts($link, $time, $ip_address)
	{
		$stmt = $link->prepare(
			"select count(*) as count from loginlogs where uhrzeit > ? and ipadresse= ?"
		);
		$stmt->bind_param("ss", $time, $ip_address);
		$stmt->execute();
		$count = $stmt->get_result()->fetch_assoc()["count"];
		return $count;
	}

	public static function setLoginAttempts($link, $time, $ip_address)
	{
		$stmt = $link->prepare(
			"insert into loginlogs(ipadresse,uhrzeit) values(?,?)"
		);
		$stmt->bind_param("ss", $ip_address, $time);
		$stmt->execute();
		//$count = $stmt->get_result()->fetch_assoc()[""];
		//return $count;
	}

	public static function deleteLoginAttempts($link, $ip_address)
	{
		$stmt = $link->prepare(
			"delete from loginlogs where ipadresse=?"
		);
		$stmt->bind_param("s", $ip_address);
		$stmt->execute();
		//$count = $stmt->get_result()->fetch_assoc()[""];
		//return $count;
	}

	public static function getUsers($link)
	{
		$stmt = $link->prepare(
			"Select * from benutzer"
		);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $result;
	}

	public static function changeRole($link, $id, $admin)
	{
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
		$stmt = $link->prepare(
			"SELECT id FROM benutzer WHERE name = ?;"
		);
		$stmt->bind_param("s", $name);
		$stmt->execute();
		$name = $stmt->get_result()->fetch_assoc()["id"];
		return $name;
	}
	
	public static function startGameOfLife() {
	    $numRows = 30;
	    $numCols = 30;
	    $gridData = [];
	    
	    for ($i = 0; $i < $numRows; $i++) {
	        $row = [];
	        for ($j = 0; $j < $numCols; $j++) {
	            $cellState = (rand(1, 10) <= 1) ? 1 : 0; // 10% chance for the cell to be alive
	            $row[] = $cellState;
	        }
	        $gridData[] = $row;
	    }
	    
	    return $gridData;
	}
	public static function saveGridToDatabase($link, $gridData)
	{
	    $clearTableQuery = "TRUNCATE TABLE grid_table";
	    $link->query($clearTableQuery);
	    
	    $insertQuery = "INSERT INTO grid_table (row_index, col_index, is_alive) VALUES (?, ?, ?)";
	    $stmt = $link->prepare($insertQuery);
	    
	    foreach ($gridData as $rowIndex => $row) {
	        foreach ($row as $colIndex => $cellState) {
	            $stmt->bind_param("iii", $rowIndex, $colIndex, $cellState);
	            $stmt->execute();
	        }
	    }
	    
	    $stmt->close();
	}
}
