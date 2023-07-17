<?php

use HaoZiTeam\ChatGPT\V1 as ChatGPTV1;

class Request
{

    private static $use_official_chatgpt_api = false;
    private static $chatGPT;

    public static function requestNews($page)
    {
        //entweder neuste news holen, oder wenn erneut geschiet weil noch nicht genug news, dann die nächste seite holen
        if ($page != null) {
            $url = 'https://newsdata.io/api/1/news?apikey=' . NEWSAPIKEY . '&country=de&language=de&category=top&page=' . $page;
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

        curl_close($curl);
        return curl_exec($curl);
    }


    public static function requestTranslate($title, $text)
    {
        //chatgpt promt
        $context = 'Ich werde dir gleich einen Titel einer news und einen Text dieser news geben. 
        Du sollst mir den Titel und den Text kinderfreundlich übersetzten. 
        Bitte vermeide es, Fachbegriffe oder Fremdwörter zu verwenden. Vermeide Fremdwörter und verwende möglichst einfache Wörter.
        Außerdem sollst du drei Fragen stellen, die sich ausschließlich auf BEDEUTUNG von Wörtern beziehen. Die Fragen sollten immer wie folgt formuliert werden: was bedeutet das Wort .. 
        Die Fragen müssen von dir mittels deiner vorhandenen Trainingsdaten beantwortbar sein und diese Antworten sollst du mir ebenfalls liefern. Die Fragen sollen sich auf den von dir übersetzten Text beziehen, nicht auf den ursprünglichen Text.
        Die json antwort von dir soll folgende keys haben: title, text, question1, question2, question3, answer1, answer2 und answer3.
        Nachdem du das json erstellt hast, maskiere innerhalb der values alle folgenden Zeichen " indem du ein Backslash vorsetzt. Zudem überprüfe dich selbst, ob du immer ein Komma nach jedem key-value paar gesetzt hast!!!!!!!!
        ';

        $prompt = 'Das ist der Titel den du umschreiben sollst: ' . $title . '  Das ist der Text den du umschreiben sollst: ' . $text . ' ';



        if (self::$use_official_chatgpt_api) {

            try {

                $apikey = CHATGPTAPIKEY;

                //Body setzen
                /*
                {
                    "model": "gpt-3.5-turbo",
                    "messages": [{"role": "user", "content": "wie heißt du?"}]
                }
                */
                $data = new stdClass();
                $data->model = "gpt-3.5-turbo";

                $messages = array();

                $message1 = new stdClass();
                $message1->role = "system";
                $message1->content = $context;
                $messages[] = $message1;

                $message2 = new stdClass();
                $message2->role = "user";
                $message2->content = $prompt;
                $messages[] = $message2;

                $data->messages = $messages;

                //header setzen
                $curl = curl_init();
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
            } catch (Exception $e) {
                $response = "public";
            }
            return $response;
        } else {
            //mit privater api
            try {
                $apikey = CHATGPTAPIKEY_PRIVATE;

                if (self::$chatGPT == null) {
                    self::$chatGPT = new ChatGPTV1();
                }
                self::$chatGPT->addAccount($apikey);
                $answers = self::$chatGPT->ask($context . $prompt);
                foreach ($answers as $item) {
                    $answer = $item;
                }
                //Array(
                //    'answer' => 'I am fine, thank you.',
                //    'conversation_id' => '<uuid>',
                //    'parent_id' => '<uuid>',
                //    'model' => 'text-davinci-002-render-sha',
                //    'account' => '0',
                //)
                //umformen in response wie wenn normale api genutzt worden wäre
                $choices = array(
                    array(
                        "message" => array(
                            "role" => "assistant",
                            "content" => $answer["answer"]
                        ),
                        "finish_reason" => "stop",
                        "index" => 0
                    )
                );

                $jsonObj = array(
                    "choices" => $choices
                );

                $jsonString = json_encode($jsonObj);
            } catch (Exception $e) {
                $jsonString = "private";
            }
            return $jsonString;
        }
    }
}
