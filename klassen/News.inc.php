<?php

class News
{

    private $link = null;
    private $news = null;
    private $finalNews = null;

    public function __construct($link)
    {
        $this->news = array();
        $this->link = $link;
        if (isset($_GET["getNews"])) {
            $getNewsSuccess = $this->getNews();
            if ($getNewsSuccess) {
                $this->translateNews();
            }
            DbFunctions::setNewsDb($link);
        }
    }

    private function getNews()
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://newsapi.org/v2/top-headlines?country=de&pageSize=10&category=general',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-Api-Key:' . NEWSAPIKEY
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            return false;
        }

        $json = json_decode($response);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if ($json->status !== "ok") {
            return false;
        }

        $count = 0;
        foreach ($json["articles"] as $artikel) {
            if ($count >= 10) {
                break;
            }
            $title = $artikel["title"];
            $text = $artikel->description;
            $title = "";
            $text = "";
            $this->news[] = array($title, $text);
            $count++;
        }


        curl_close($curl);
    }


    private function translateNews()
    {
    }
}
