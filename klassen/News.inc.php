<?php
//damit script nicht abgebrochen wird wenn request länger dauert. Ungefähr 8 minuten jetzt möglich, gebraucht werden so 3 Minuten.
set_time_limit(500);

class News
{
    //von welchen Quellen die News bezogen werden sollen
    //private const SOURCES = array("heise", "sport1", "tagesschau", "bild", "promiflash", "taz", "tagesspiegel", "ndr", "chip", "filmstarts", "eurosport", "sueddeutsche", "techbook", "derwesten", "spiegel", "n-tv", "focus", "futurezone_de", "news_de", "golem", "tagesschau", "finanz-szene", "frankenpost", "faz", "deutschlandfunk", "t-online", "sportschau", "scinexx", "ruhr24", "netzwelt", "computerbase", "zeit", "stern", "swr", "presseportal");
    //vov welchen quellen nicht
    private const SOURCES = array("wort", "cryptoticker");


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
        if ($this->login->isUserAdmin() && isset($_GET["getNews"])) {
            //ganz wichtig die session datei wieder freigeben!sonnst wird session datei geblockt während der heavy task ausgeführt wird
            //und dabei können dann keine weiteren clients die website abrufen
            session_write_close();
            $success = $this->getNews();
            //wenn news erfolgreich geholt wurden, dann übersetze sie und speichere sie in der db
            if ($success) {
                $this->translateNews();
                DBNews::setNewsDb($this->link, $this->news, $this->newsTranslated);
            }
            //zeige fehler an falls vorhanden, also bei welchen news es nicht geklapt hat und warum
            Logs::jsonLogs();
        }
        if ($this->login->isUserLoggedIn()) {
            //like speichern
            if (isset($_GET["like"]) && $_GET["like"] == "like") {
                DBBewertung::like($link, DBHelper::escape($link, $_GET["id"]));
                die();
            } else if (isset($_GET["like"]) && $_GET["like"] == "removeLike") {
                //like entfernen
                DBBewertung::removeLike($link, DBHelper::escape($link, $_GET["id"]));
                die();
            }
        }
    }


    private function getNews()
    {
        //hole solange news(pro Request 10) bis es mind. 10 Stück mit content gibt
        //höchstens aber 2 requests
        $success = true;
        $counter = 0;
        while ($success && count($this->news) < 10 && $counter < 2) {
            $success = $this->getNews10();
            $counter++;
        }

        /*
        //lösche wenn mehr als 5
        if (count($this->news) > 10) {
            $this->news = array_slice($this->news, 0, 10);
        }
        */

        //umdrehen damit neuste news als letztes in db eingefügt werden. nicht mehr nötig aufgrund von date, aber bleibt erst mal so
        $this->news = array_reverse($this->news);

        return $success;
    }

    private function getNews10()
    {
        $response = Request::requestNews($this->page);

        if ($response === false) {
            Logs::addError("Fehler beim holen der News. Request nicht erfolgreich.");
            return false;
        }

        //json in php array umwandeln
        $json = json_decode($response);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Logs::addError("Fehler beim holen der News. Response Json enthält Fehler.");
            return false;
        }

        if ($json->{'status'} !== "success") {
            Logs::addError("Fehler beim holen der News. Response Json status != success.");
            return false;
        }
        //für nächste request
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

        //doppelte news entfernen falls api doppelte liefert
        //ind filterNews werden ja nur doppelte aus datenbank berücksichtigt
        $this->news = array_unique($this->news, SORT_REGULAR);


        return true;
    }


    private function filterNews($article)
    {

        //nur wenn content vorhanden
        $content = $article->{"content"};
        $image = $article->{"image_url"};
        if ($content == null || empty($content) || $content == "None" || $content == "none" || $content == "null" || $content == "NULL" || $content == "Null") {
            return false;
        }
        //nur wenn bild vorhanden

        if ($image == null || empty($image) || $image == "None" || $image == "none" || $image == "null" || $image == "NULL" || $image == "Null") {
            return false;
        }



        //article ist vom typ obkject und SOURCES vom typ array
        //deshalb erst in array umwandeln
        $article = (array) $article;

        //nur bestimmte Quellen. Api erlaubt keine Quellen filterung

        ///!!!wenn nicht im array dann weiter!!!!!! also hier werden quellen aussortiert
        if (in_array($article["source_id"], self::SOURCES)) {
            return false;
        }



        //nur die neusten news
        $newsOld = DBNews::getNewsDb($this->link);
        //nicht weiter ab hier wenn keine alten vorhanden
        if ($newsOld == null) {
            return true;
        }
        foreach ($newsOld as $old) {
            //news bereits vorhanden
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

                //chatgpt übersetzen lassen
                $response = Request::requestTranslate($title, $text);

                if ($response === "private" || $response === "public") {
                    Logs::addError("Fehler beim übersetzten der $counter. von " . (count($this->news) + 1) . ". News. $response API Error.");
                    $this->placeholder();
                    $counter++;
                    continue;
                }

                if ($response === false) {
                    Logs::addError("Fehler beim übersetzten der $counter. von " . (count($this->news) + 1) . ". News. Request nicht erfolgreich.");
                    $this->placeholder();
                    $counter++;
                    continue;
                }

                //json in php array umwandeln
                $json = json_decode($response);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    Logs::addError("Fehler beim übersetzten der $counter. von " . (count($this->news) + 1) . ".  News. Response Json enthält Fehler.");
                    $this->placeholder();
                    $counter++;
                    continue;
                }

                if (isset($json->error) && !empty($json->error)) {
                    Logs::addError("Fehler beim übersetzten der $counter. von " . (count($this->news) + 1) . ".  News. Response Json enthält Fehler.");
                    $this->placeholder();
                    $counter++;
                    continue;
                }

                //output von chatgpt holen
                $responseText = $json->{"choices"}[0]->{"message"}->{"content"};
                //führende und nachstehende leerzeichen entfernen
                $responseText = trim($responseText);


                //da chat als antwort auch json liefert, wieder json in php array umwandeln
                $myJson = json_decode($responseText);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Logs::addError("Fehler beim übersetzten der $counter. von " . count($this->news) . ". News. Response erfolgreich, aber ChatGPT hat kein valides JSON geliefert.");
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

                Logs::addSuccess("Es wurden $counter neue News geholt und kinderfreundlich übersetzt!");

                $counter++;
            } catch (Exception $e) {
                Logs::addError("Unbekannter Fehler beim übersetzten der $counter. von " . count($this->news) . ".");
                $this->placeholder();
                $counter++;
                continue;
            }
        }

        if ($counter == 1) {
            Logs::addMessage("Die news sind auf dem neusten Stand.");
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
