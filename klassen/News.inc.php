<?php

class News
{

    private $link = null;
    private $login = null;
    private $news = null;
    private $newsTranslated = null;

    public function __construct($link, $login)
    {
        $this->login = $login;
        $this->news = array();
        $this->newsTranslated = array();


        /*
        //!!!!!!!!!!!!!!!!Mockdaten!!!!!!!!!!!!!!!!!!!
        $this->news = array(
            array(
                'title' => "Zollbehörde : Russland erzielt Handelsüberschuss von 300 Milliarden Euro",
                'text' => "Russland hat im vergangenen Jahr dank hoher Ölpreise einen Handelsüberschuss von 332,4 Milliarden Dollar (gut 311 Milliarden Euro) erzielt. Das Exportvolumen sei um 19,9 Prozent auf 591,5 Milliarden Dollar gestiegen, der Import im gleichen Zeitraum um 11,7 Prozent auf 259,1 Milliarden Dollar geschrumpft, teilte die Zollbehörde am Montag mit. Gegenüber 2021 ist der Handelsüberschuss Russlands damit um 68 Prozent gewachsen. Hauptgrund für die Entwicklung war der Ölpreis . So konnte Russland - ungeachtet seines Kriegs gegen die Ukraine - die Einnahmen aus dem Verkauf von Rohöl und Ölprodukten 2022 noch um 42 Prozent steigern. Gleichzeitig schränkten die gegen Russland wegen seines Angriffskriegs gegen die Ukraine erlassenen Sanktionen den Import ein. Moskau veröffentlicht wegen der Sanktionen seine Statistiken nur teilweise. Die Publikation der Zahlen durch den Zoll soll offenbar verdeutlichen, wie gut das Land damit zurechtkommt. Eine Fortsetzung des Trends dieses Jahr ist allerdings nicht zu erwarte"
            ),
            array(
                'title' => "Basketball: Nördlinger Eigengewächse wehren sich tapfer in Vilsbiburg",
                'text' => "Mit dem jüngsten Kader der Liga, mit gerade einmal 19 Jahren im Schnitt, hat sich ein verändertes Nördlinger Basketball-Team gut im ersten Platzierungsspiel in Vilsbiburg präsentiert. Über drei Viertel spielte die Truppe von Trainer Mohammed Hajjar auf Augenhöhe mit dem Tabellenzweiten in Bestbesetzung. Am Ende müssen sich die Gäste den erfahrenen Hausherren trotz aufopferungsvollen Kampfs mit 60:79 geschlagen geben. Center Robin Seeberger und sieben Spieler, die allesamt aus dem eigenen Jugendprogramm stammen, traten zum Spiel um Platz fünf bei den Baskets aus Vilsbiburg an. Statt den drei Topscorern der bisherigen Saison Eichler , Stone und Mateus setzte Hajjar auf die Rieser Eigengewächse, die viele Spielminuten und Verantwortung bekommen sollten. Für den etatmäßigen Aufbauspieler Pascal Schröppel bekamen die Brüder Max und Jakob Scherer ihre ersten Spielminuten in der 1. Regionalliga und auch die beiden Jüngsten, der 16-jährige Lukas Hahn und der 15-jährige Felix Stoll, sollten die fehle"
            )
        );

        
        $this->newsTranslated = array(
            array(
                'title' => "Russland hat mehr Einkommen als Ausgaben im Handel",
                'text' => "Letztes Jahr hat Russland dank des hohen Ölpreises mehr Geld eingenommen als ausgegeben im Handel mit anderen Ländern. Der Betrag war ungefähr 311 Milliarden Euro. Russland hat mehr Sachen (zum Beispiel Öl) verkauft als gekauft. Der Grund dafür war der hohe Ölpreis. Obwohl es momentan Krieg gibt, konnte Russland immer noch viel Geld verdienen. Andere Länder haben aber nicht so viel Sachen an Russland verkauft. Deswegen hat Russland weniger Sachen gekauft. Deshalb hatte Russland mehr Geld als ausgegeben. Es wird aber erwartet, dass es dieses Jahr nicht wieder so sein wird."
            ),
            array(
                'title' => "Basketball: Junges Nördlinger Team spielt mutig gegen starke Gegner in Vilsbiburg",
                'text' => "Das Nördlinger Basketball-Team, das im Schnitt nur 19 Jahre alt ist, hat sich in Vilsbiburg gut geschlagen. Obwohl sie gegen einen starken Gegner angetreten sind, haben sie über drei Viertel des Spiels gleichauf gespielt. Am Ende haben sie leider mit 60:79 verloren. Trainer Mohammed Hajjar hat viele junge Spieler aus dem eigenen Jugendprogramm aufgestellt, die normalerweise weniger Einsatzzeit bekommen. Zum Beispiel haben die Brüder Max und Jakob Scherer ihre ersten Spielminuten in der 1. Regionalliga bekommen. Auch die beiden Jüngsten, 16-jährige Lukas Hahn und 15-jährige Felix Stoll, durften spielen."
            )
        );

        $success = true;
        //!!!!!!!!!!!!!!!!Mockdaten!!!!!!!!!!!!!!!!!!!
        */

        $this->link = $link;
        if (isset($_GET["getNews"]) && $this->login->isUserAdmin()) {
            $success = $this->getNews();
            if ($success) {
                $this->translateNews();
                DbFunctions::setNewsDb($link, $this->news, $this->newsTranslated);
            }
            Logs::jsonLogs();
        }
    }

    private function getNews()
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://newsdata.io/api/1/news?apikey=' . NEWSAPIKEY . '&country=de&language=de&category=top',
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

        $count = 0;
        foreach ($json->{"results"} as $result) {
            if ($count >= 10) {
                break;
            }
            $title = $result->{"title"};
            $text = $result->{"content"};
            $this->news[] = array(
                'title' => $title,
                'text' => $text
            );
            $count++;
        }

        curl_close($curl);
        return true;
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
            $maxLength = 7366;
            if (strlen($text) > $maxLength) {
                $text = substr($text, 0, $maxLength);
            }

            $prompt = 'Ich werde dir gleich einen Titel einer news und einen Text dieser news geben. Du sollst mir den Titel und den Text kinderfreundlich übersetzten. Das heißt, der Titel und der Text sollen in leichten verständlichen deutsch lesbar und nachvollziehbar sein. Es sollen selbst 10 jährige Kinder den Text verstehen können. Der neue Text soll von der Länge nicht viel kürzer sein als der ursprüngliche, BEACHTE DAS BITTE!!!!. Außerdem sollst du mir drei Fragen zu dem ursprünglichen Text erstellen. Diese Fragen sollen Kinder fragen simulieren und sich besonders auf Begriffe aus dem Text beziehen, die sie nicht verstehen. Die Fragen müssen von dir mittels deiner vorhandenen Trainingsdaten oder mittels der Information des Textes beantwortbar sein. WICHTIG, du sollst mir auschließlich im json format antworten. Die json antwort soll so aussehen: {"title":"Hier der umgeschriebene Titel von dir","text":"Hier der umgeschriebene Text von dir","question1":"Hier deine 1. Frage","question2":"Hier deine 2. Frage","question3":"Hier deine 3. Frage"}. Beachte unbedingt, dass du nur in vom mir gezeigten json format antwortest. Das ist der Titel den du umschreiben sollst: ||' . $title . '||  Das ist der Text den du umschreiben sollst: ||' . $text . '||';
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
                break;
            }

            $json = json_decode($response);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Logs::addError("Fehler beim übersetzten der $counter. News. Response Json enthält Fehler.");
                break;
            }

            if (isset($json->error) && !empty($json->error)) {
                Logs::addError("Fehler beim übersetzten der $counter. News. Response Json enthält Fehler.");
                break;
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
                break;
            }
            $translatedTitle = $myJson->{"title"};
            $translatedText = $myJson->{"text"};
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

            $this->newsTranslated[] = array(
                'title' => $translatedTitle,
                'text' => $translatedText,
                'question1' => $question1,
                'question2' => $question2,
                'question3' => $question3
            );

            $counter++;
        }

        curl_close($curl);
    }
}
