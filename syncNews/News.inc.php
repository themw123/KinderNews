<?php
//damit script nicht abgebrochen wird wenn request länger dauert. Ungefähr 8 minuten jetzt möglich, gebraucht werden so 3 Minuten.
set_time_limit(500);

class News
{

    private $link = null;
    private $news = null;
    private $newsTranslated = null;
    private $page = null;

    public function __construct()
    {
        $this->news = array();
        $this->newsTranslated = array();
        $this->link = DbFunctions::connectWithDatabase();

        $success = $this->getNews();
        if ($success) {
            $this->onlyNewNews();
            $this->translateNews();
            DbFunctions::setNewsDb($this->link, $this->news, $this->newsTranslated);
        }
    }


    private function getNews()
    {
        //hole solange news(pro Request 10) bis es 10 Stück mit content gibt
        //maximal 10 Runden/Requests
        $success = true;
        $counter = 0;
        while ($success && count($this->news) < 10 && $counter < 10) {
            $success = $this->getNews10();
            $counter++;
        }

        //lösche wenn mehr als 10
        if (count($this->news) > 10) {
            $this->news = array_slice($this->news, 0, 10);
        }

        //umdrehen damit neuste news als letztes in db eingefügt werden. nicht mehr nötig aufgrund von date, aber bleibt erst mal so
        $this->news = array_reverse($this->news);

        return $success;
    }

    private function getNews10()
    {
        $response = Request::requestNews($this->page);

        if ($response === false) {
            return false;
        }

        $json = json_decode($response);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if ($json->{'status'} !== "success") {
            return false;
        }

        $this->page = $json->{"nextPage"};


        foreach ($json->{"results"} as $result) {
            $content = $result->{"content"};
            $image = $result->{"image_url"};
            //nur news aufnehmen die einen content also text und ein bild haben
            if ($content != null && !empty($content) && $content != "None" && $content != "none" && $content != "null" && $content != "NULL" && $content != "Null") {
                if ($image != null && !empty($image) && $image != "None" && $image != "none" && $image != "null" && $image != "NULL" && $image != "Null") {
                    $title = $result->{"title"};
                    $date = $result->{"pubDate"};
                    $this->news[] = array(
                        'title' => $title,
                        'text' => $content,
                        'image' => $image,
                        'date' => $date,
                    );
                }
            }
        }

        return true;
    }


    private function onlyNewNews()
    {

        $newsOld = DbFunctions::getNewsDb($this->link);

        if ($newsOld == null) {
            return;
        }


        foreach ($newsOld as $old) {
            $oldTitles[] = $old['originaler_titel'];
        }

        foreach ($this->news as $new) {
            $newTitles[] = $new['title'];
        }

        $diffTitles = array_diff($newTitles, $oldTitles);

        //nur die News wo title noch nicht vorhanden
        $diffNews = array();
        foreach ($this->news as $new) {
            if (in_array($new['title'], $diffTitles)) {
                $diffNews[] = $new;
            }
        }

        $this->news = $diffNews;
    }

    private function translateNews()
    {

        $counter = 1;
        foreach ($this->news as $article) {

            $title = $article['title'];
            $text = $article['text'];

            //als eingabe ungefähr 1 1/2 Word Seiten, also 7366 Zeichen (≈2800 Token) und als Ausgabe ungefähr 3/4 Word Seite = 3159 Zeichen (≈1200 Token)
            //mit 1 1/2 Word Seiten als Eingabe und 3/4 Word Seite als Ausgabe, sind es dann 4000 Token 
            //quelle https://platform.openai.com/tokenizer

            //wenn zu groß, dann kürzen.
            //abzüglich ungefähr 1900 für input promt also 7366 - 1900 = 5466
            $maxLength = 5466;
            if (strlen($text) > $maxLength) {
                $text = substr($text, 0, $maxLength);
            }

            $response = Request::requestTranslate($title, $text);

            if ($response === "private_error") {
                $this->placeholder();
                $counter++;
            }

            if ($response === false) {
                $this->placeholder();
                $counter++;
                continue;
            }

            $json = json_decode($response);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->placeholder();
                $counter++;
                continue;
            }

            if (isset($json->error) && !empty($json->error)) {
                $this->placeholder();
                $counter++;
                continue;
            }

            $responseText = $json->{"choices"}[0]->{"message"}->{"content"};
            $responseText = trim($responseText);

            /*
                //falls chatgpt die antwort früher abbricht und deshalb kein } ans ende fügt.
                // Überprüfen, ob das letzte Zeichen ein } ist
                $lastCharIndex = strlen($responseText) - 1;
                if (substr($responseText, $lastCharIndex, 1) != "}") {
                    if (substr($responseText, $lastCharIndex, 1) != "'") {
                        $responseText = $responseText . "'}";
                    } else {
                        $responseText = $responseText . "}";
                    }
                }
                */

            $myJson = json_decode($responseText);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->placeholder();
                $counter++;
                continue;
            }
            $translatedTitle = $myJson->{"title"};
            $translatedText = $myJson->{"text"};
            $preview = substr($translatedText, 0, 167) . "...";

            if (isset($myJson->{"question1"})) {
                $question1 = $myJson->{"question1"};
            } else {
                $question1 = "error";
            }
            if (isset($myJson->{"question2"})) {
                $question2 = $myJson->{"question2"};
            } else {
                $question2 = "error";
            }
            if (isset($myJson->{"question3"})) {
                $question3 = $myJson->{"question3"};
            } else {
                $question3 = "error";
            }

            if (isset($myJson->{"answer1"})) {
                $answer1 = $myJson->{"answer1"};
            } else {
                $answer1 = "error";
            }
            if (isset($myJson->{"answer2"})) {
                $answer2 = $myJson->{"answer2"};
            } else {
                $answer2 = "error";
            }
            if (isset($myJson->{"answer3"})) {
                $answer3 = $myJson->{"answer3"};
            } else {
                $answer3 = "error";
            }

            $this->newsTranslated[] = array(
                'title' => $translatedTitle,
                'text' => $translatedText,
                'preview' => $preview,
                'question1' => $question1,
                'question2' => $question2,
                'question3' => $question3,
                'answer1' => $answer1,
                'answer2' => $answer2,
                'answer3' => $answer3
            );


            $counter++;
        }

        if ($counter == 1) {
        }
    }

    //falls translate nicht erfolgreich. Damit bei dem einfügen der Daten in die Datenbank nichts durcheinanderkommt.
    private function placeholder()
    {
        $this->newsTranslated[] = array(
            'title' => "error",
            'text' => "error",
            'preview' => "error",
            'question1' => "error",
            'question2' => "error",
            'question3' => "error",
            'answer1' => "error",
            'answer2' => "error",
            'answer3' => "error"
        );
    }
}
