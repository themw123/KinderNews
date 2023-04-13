<?php
//damit script nicht abgebrochen wird wenn request länger dauert. Ungefähr 8 minuten jetzt möglich, gebraucht werden so 3 Minuten.
set_time_limit(500);

class News
{
    //von welchen Quellen die News bezogen werden sollen
    //private const SOURCES = array("heise", "sport1", "tagesschau", "bild", "promiflash", "taz", "tagesspiegel", "ndr", "chip", "filmstarts", "eurosport", "sueddeutsche", "techbook", "derwesten", "spiegel", "n-tv", "focus", "futurezone_de", "news_de", "golem", "tagesschau", "finanz-szene", "frankenpost", "faz", "deutschlandfunk", "t-online", "sportschau", "scinexx", "ruhr24", "netzwelt", "computerbase", "zeit", "stern", "swr", "presseportal");
    //vov welchen quellen nicht
    private const SOURCES = array("wort");


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
            $this->translateNews();
            DbFunctions::setNewsDb($this->link, $this->news, $this->newsTranslated);
        }
    }


    private function getNews()
    {
        //hole solange news(pro Request 10) bis es 10 Stück mit content gibt
        //maximal 8 Runden/Requests -> für productiv betrieb. news api erlaubt 200 Reqeusts pro Tag. Es soll jede Stunde aktualisiert werden. 200/24 = 8
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


        $json = $json->{"results"};
        foreach ($json as $article) {
            $filter = $this->filterNews($article);
            if ($filter) {
                $title = $article->{"title"};
                $content = $article->{"content"};
                $image = $article->{"image_url"};
                $source = $article->{"source_id"};
                $date = $article->{"pubDate"};
                $this->news[] = array(
                    'title' => $title,
                    'text' => $content,
                    'image' => $image,
                    'date' => $date,
                    'source' => $source
                );
            }
        }

        return true;
    }


    private function filterNews($article)
    {

        //nur wenn content und image vorhanden
        $content = $article->{"content"};
        $image = $article->{"image_url"};
        if ($content == null || empty($content) || $content == "None" || $content == "none" || $content == "null" || $content == "NULL" || $content == "Null") {
            return false;
        }
        /*
        if ($image == null || empty($image) || $image == "None" || $image == "none" || $image == "null" || $image == "NULL" || $image == "Null") {
            return false;
        }
        */


        //article ist vom typ obkject und SOURCES vom typ array
        //deshalb erst in array umwandeln
        $article = (array) $article;



        ///!!!wenn nicht im array dann weiter!!!!!! also hier werden quellen aussortiert
        if (in_array($article["source_id"], self::SOURCES)) {
            return false;
        }



        //nur die neusten news
        $newsOld = DbFunctions::getNewsDb($this->link);
        //nicht weiter ab hier wenn keine alten vorhanden
        if ($newsOld == null) {
            return true;
        }
        foreach ($newsOld as $old) {
            if ($old["originaler_titel"] == $article["title"]) {
                return false;
            }
        }

        return true;
    }

    private function translateNews()
    {

        $counter = 1;
        foreach ($this->news as $article) {


            try {

                
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
