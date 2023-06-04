<?php

class DBBewertung
{

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
}
