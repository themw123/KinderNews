<?php
//damit script nicht abgebrochen wird wenn request länger dauert. Ungefähr 8 minuten jetzt möglich, gebraucht werden so 3 Minuten.
set_time_limit(500);

class News
{

    private $link = null;
    private $login = null;
    private $news = null;
    private $newsTranslated = null;

    private $page = null;

    public function __construct($link, $login)
    {
        $this->login = $login;
        $this->news = array();
        $this->newsTranslated = array();
        $this->link = $link;


        /*
        //!!!!!!!!!!!!!!!!Mockdaten!!!!!!!!!!!!!!!!!!!
        $this->news = array(
            array(
                'title' => "Zollbehörde : Russland erzielt Handelsüberschuss von 300 Milliarden Euro",
                'text' => "Russland hat im vergangenen Jahr dank hoher Ölpreise einen Handelsüberschuss von 332,4 Milliarden Dollar (gut 311 Milliarden Euro) erzielt. Das Exportvolumen sei um 19,9 Prozent auf 591,5 Milliarden Dollar gestiegen, der Import im gleichen Zeitraum um 11,7 Prozent auf 259,1 Milliarden Dollar geschrumpft, teilte die Zollbehörde am Montag mit. Gegenüber 2021 ist der Handelsüberschuss Russlands damit um 68 Prozent gewachsen. Hauptgrund für die Entwicklung war der Ölpreis . So konnte Russland - ungeachtet seines Kriegs gegen die Ukraine - die Einnahmen aus dem Verkauf von Rohöl und Ölprodukten 2022 noch um 42 Prozent steigern. Gleichzeitig schränkten die gegen Russland wegen seines Angriffskriegs gegen die Ukraine erlassenen Sanktionen den Import ein. Moskau veröffentlicht wegen der Sanktionen seine Statistiken nur teilweise. Die Publikation der Zahlen durch den Zoll soll offenbar verdeutlichen, wie gut das Land damit zurechtkommt. Eine Fortsetzung des Trends dieses Jahr ist allerdings nicht zu erwarte",
                'image' => "https:/......."
            ),
            array(
                'title' => "Basketball: Nördlinger Eigengewächse wehren sich tapfer in Vilsbiburg",
                'text' => "Mit dem jüngsten Kader der Liga, mit gerade einmal 19 Jahren im Schnitt, hat sich ein verändertes Nördlinger Basketball-Team gut im ersten Platzierungsspiel in Vilsbiburg präsentiert. Über drei Viertel spielte die Truppe von Trainer Mohammed Hajjar auf Augenhöhe mit dem Tabellenzweiten in Bestbesetzung. Am Ende müssen sich die Gäste den erfahrenen Hausherren trotz aufopferungsvollen Kampfs mit 60:79 geschlagen geben. Center Robin Seeberger und sieben Spieler, die allesamt aus dem eigenen Jugendprogramm stammen, traten zum Spiel um Platz fünf bei den Baskets aus Vilsbiburg an. Statt den drei Topscorern der bisherigen Saison Eichler , Stone und Mateus setzte Hajjar auf die Rieser Eigengewächse, die viele Spielminuten und Verantwortung bekommen sollten. Für den etatmäßigen Aufbauspieler Pascal Schröppel bekamen die Brüder Max und Jakob Scherer ihre ersten Spielminuten in der 1. Regionalliga und auch die beiden Jüngsten, der 16-jährige Lukas Hahn und der 15-jährige Felix Stoll, sollten die fehle",
                'image' => "https:/......."
            )
        );

        
        $this->newsTranslated = array(
            array(
                'title' => "Russland hat mehr Einkommen als Ausgaben im Handel",
                'text' => "Letztes Jahr hat Russland dank des hohen Ölpreises mehr Geld eingenommen als ausgegeben im Handel mit anderen Ländern. Der Betrag war ungefähr 311 Milliarden Euro. Russland hat mehr Sachen (zum Beispiel Öl) verkauft als gekauft. Der Grund dafür war der hohe Ölpreis. Obwohl es momentan Krieg gibt, konnte Russland immer noch viel Geld verdienen. Andere Länder haben aber nicht so viel Sachen an Russland verkauft. Deswegen hat Russland weniger Sachen gekauft. Deshalb hatte Russland mehr Geld als ausgegeben. Es wird aber erwartet, dass es dieses Jahr nicht wieder so sein wird.",
                'question1' => "wer?",
                'question2' => "wie?",
                'question3' => "was?",
                'question3' => "was?",

            ),
            array(
                'title' => "Basketball: Junges Nördlinger Team spielt mutig gegen starke Gegner in Vilsbiburg",
                'text' => "Das Nördlinger Basketball-Team, das im Schnitt nur 19 Jahre alt ist, hat sich in Vilsbiburg gut geschlagen. Obwohl sie gegen einen starken Gegner angetreten sind, haben sie über drei Viertel des Spiels gleichauf gespielt. Am Ende haben sie leider mit 60:79 verloren. Trainer Mohammed Hajjar hat viele junge Spieler aus dem eigenen Jugendprogramm aufgestellt, die normalerweise weniger Einsatzzeit bekommen. Zum Beispiel haben die Brüder Max und Jakob Scherer ihre ersten Spielminuten in der 1. Regionalliga bekommen. Auch die beiden Jüngsten, 16-jährige Lukas Hahn und 15-jährige Felix Stoll, durften spielen.",
                'question1' => "wer?",
                'question2' => "wie?",
                'question3' => "was?",
            )
        );
        
        $success = true;
        //!!!!!!!!!!!!!!!!Mockdaten!!!!!!!!!!!!!!!!!!!
        */

        if (isset($_GET["getNews"]) && $this->login->isUserAdmin()) {
            //ganz wichtig die session datei wieder freigeben!sonnst wird session datei geblockt während der heavy task ausgeführt wird
            //und dabei können dann keine weiteren clients die website abrufen
            session_write_close();
            $success = $this->getNews();
            if ($success) {
                $this->onlyNewNews();
                $this->translateNews();
                DbFunctions::setNewsDb($link, $this->news, $this->newsTranslated);
            }
            Logs::jsonLogs();
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

        if ($this->page != null) {
            $url = 'https://newsdata.io/api/1/news?apikey=' . NEWSAPIKEY . '&country=de&language=de&category=top&page=' . $this->page;
        } else {
            $url = 'https://newsdata.io/api/1/news?apikey=' . NEWSAPIKEY . '&country=de&language=de&category=top';
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            Logs::addError("Fehler beim holen der News. Request nicht erfolgreich.");
            return false;
        }

        $json = json_decode($response);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Logs::addError("Fehler beim holen der News. Response Json enthält Fehler.");
            return false;
        }

        if ($json->{'status'} !== "success") {
            Logs::addError("Fehler beim holen der News. Response Json status != success.");
            return false;
        }

        $this->page = $json->{"nextPage"};


        foreach ($json->{"results"} as $result) {
            $content = $result->{"content"};
            //nur news aufnehmen die einen content also text haben
            if (!empty($content) && $content != "None" && $content != "none" && $content != "null" && $content != "NULL" && $content != "Null") {
                $title = $result->{"title"};
                $text = $result->{"content"};
                $image = $result->{"image_url"};
                $date = $result->{"pubDate"};
                if (empty($image) || $image == "None" || $image == "none" || $image == "null" || $image == "NULL" || $image == "Null") {
                    $image = "error";
                }
                $this->news[] = array(
                    'title' => $title,
                    'text' => $text,
                    'image' => $image,
                    'date' => $date,
                );
            }
        }


        curl_close($curl);
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

        $curl = curl_init();

        $counter = 1;
        foreach ($this->news as $article) {

            $apikey = CHATGPTAPIKEY;
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

            $prompt = 'Ich werde dir gleich einen Titel einer news und einen Text dieser news geben. Du sollst mir den Titel und den Text kinderfreundlich übersetzten. Das heißt, der Titel und der Text sollen in leichten verständlichen deutsch lesbar und nachvollziehbar sein. Außerdem sollst du mir drei Fragen zu dem ursprünglichen Text erstellen. Diese Fragen sollen Kinder fragen simulieren und sich besonders auf Fragen zu Begriffen aus dem Text beziehen. Die Fragen müssen von dir mittels deiner vorhandenen Trainingsdaten oder mittels der Information des Textes beantwortbar sein und diese Antworten sollst du mir ebenfalls liefern. WICHTIG, du sollst mir auschließlich im json format antworten und dabei für den Inhalt für den von dir ungeschriebenen Titel, Text, question1, question2, question3, answer1, answer2 und answer3 nicht das Zeichen " sondern stattdessen das Zeichen “ nutzten. Die json antwort soll so aussehen: {"title":"Hier der umgeschriebene Titel von dir","text":"Hier der umgeschriebene Text von dir","question1":"Hier deine 1. Frage","question2":"Hier deine 2. Frage","question3":"Hier deine 3. Frage","answer1":"Hier deine Antwort zur 1. Frage","answer2":"Hier deine Antwort zur 2. Frage","answer3":"Hier deine Antwort zur 3. Frage"} . Beachte unbedingt, dass du nur in vom mir gezeigten json format antwortest. Das ist der Titel den du umschreiben sollst: ||' . $title . '||  Das ist der Text den du umschreiben sollst: ||' . $text . '|| . GANZ WICHTIG: ÜBERPRÜFE AM ENDE OB DER VON DIR ERZEUGTE TEXT AUCH WIRKLICH IM JSON FORMAT IST UND SORGE DAFÜR SOFERN ES NICHT DER FALL IST!!!!! ';

            $data = new stdClass();
            $data->model = "gpt-3.5-turbo";

            $messages = array();
            $message1 = new stdClass();
            $message1->role = "user";
            $message1->content = $prompt;
            $messages[] = $message1;

            $data->messages = $messages;

            //$promt = "was geht";
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    "Authorization: Bearer $apikey"
                ),
            ));

            $response = curl_exec($curl);

            if ($response === false) {
                Logs::addError("Fehler beim übersetzten der $counter. News. Request nicht erfolgreich.");
                continue;
            }

            $json = json_decode($response);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Logs::addError("Fehler beim übersetzten der $counter. News. Response Json enthält Fehler.");
                continue;
            }

            if (isset($json->error) && !empty($json->error)) {
                Logs::addError("Fehler beim übersetzten der $counter. News. Response Json enthält Fehler.");
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
                Logs::addError("Fehler beim übersetzten der $counter. News. Response erfolgreich, aber ChatGPT hat kein valides JSON geliefert.");
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

            Logs::addSuccess("Es wurden $counter neue News geholt und kinderfreundlich übersetzt!");

            $counter++;
        }

        if ($counter == 1) {
            Logs::addMessage("Die news sind auf dem neusten Stand.");
        }

        curl_close($curl);
    }
}
