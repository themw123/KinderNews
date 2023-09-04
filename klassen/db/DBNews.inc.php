<?php

class DBNews
{
    public static function setNewsDb($link, $news, $newsTranslated)
    {

        //neue news setzten
        $stmt = $link->prepare(
            "INSERT INTO news (originaler_titel , originaler_text, uebersetzter_titel , uebersetzter_text, uebersetzte_preview, frage1, frage2, frage3, answer1 , answer2, answer3, bild_url, quelle, link, date)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);"
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
            $link = $news[$key]['link'];
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

            $stmt->bind_param("sssssssssssssss", $original_title, $original_text, $translated_title, $translated_text, $translated_preview, $question1, $question2, $question3, $answer1, $answer2, $answer3, $image_url, $source, $link, $date);
            $stmt->execute();
        }
    }

    public static function getNewsWithLikesCount($link, $user_id)
    {
        //alle news aus der db holen, neuste zuerst, nur neuste 100
        //durch subquery etwas bessere performance
        // in subquery nach news.id desc sortieren weil das viel schneller als date ist. liefert fast selbest ergebnis nur letzte 5 oder so könnten dadurch anders sein weils ja auf 100 limitiert ist. Fix dafür: einmal limit 110 und einmal 100
        $stmt = $link->prepare(
            "
            SELECT
                COUNT(bewertung.news_id) AS likes,
                MAX(
                    CASE
                        WHEN bewertung.benutzter_id = $user_id THEN TRUE
                        ELSE FALSE
                    END
                ) AS liked,
                news.*
            FROM
                (
                    SELECT * FROM news
                    ORDER by
                    news.id DESC
                    LIMIT 110
                ) AS news
            LEFT JOIN
                bewertung ON bewertung.news_id = news.id
            GROUP BY
                news.id
            ORDER by
                news.date DESC
            LIMIT 100
            ;"
        );
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $result = self::changeToGerman($result);
        return $result;
    }

    public static function getLikedNewsByUserAndItsLikesCount($link, $name)
    {
        //alle news die ein user geliked hat
        $stmt = $link->prepare(
            "
            SELECT
                benutzer.name,
                COUNT(bewertung1.id) AS likes,
                true AS liked,
                news.*
            FROM
                bewertung AS bewertung1
            INNER JOIN
                news ON bewertung1.news_id = news.id
            INNER JOIN
                benutzer ON bewertung1.benutzter_id = benutzer.id
            LEFT JOIN
                bewertung AS bewertung2 ON news.id = bewertung2.news_id
            WHERE
                benutzer.name = '$name'
            GROUP BY
                bewertung1.id,
                bewertung1.news_id,
                bewertung1.benutzter_id,
                benutzer.name
            ORDER BY
                news.date DESC
                    
            ;"
        );
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }


    public static function getNewsDb($link)
    {
        //alle news aus der db holen, neuste zuerst, nur neuste 100
        $stmt = $link->prepare(
            "Select * from news order by date desc LIMIT 100;"
        );
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $result = self::changeToGerman($result);
        return $result;
    }


    public static function getNewsArticleDb($link, $id)
    {
        //eine bestimmte news aus der db holen
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
