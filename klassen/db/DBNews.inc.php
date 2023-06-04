<?php

class DBNews
{
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

    public static function getAllNewsDb($link)
    {
        $stmt = $link->prepare(
            "Select * from news order by date desc"
        );
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $result = self::changeToGerman($result);
        return $result;
    }

    public static function getNewsDb($link)
    {
        $stmt = $link->prepare(
            "Select * from news order by date desc LIMIT 100;"
        );
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $result = self::changeToGerman($result);
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

    private static function changeToGerman($array)
    {
        // Das Datum für jede Zeile umwandeln
        foreach ($array as &$row) {
            $timestamp = strtotime($row['date']);
            $row['date'] = date('d.m.Y H:i:s', $timestamp);
        }
        return $array;
    }
}
