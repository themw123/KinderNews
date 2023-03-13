<?php

class News
{

    private $link = null;
    private $news = null;
    private $finalNews = null;

    public function __construct($link)
    {
        $this->link = $link;
        if (isset($_GET["getNews"])) {
            $this->getNews();
            $this->translateNews();
            DbFunctions::setNewsDb($link);
        }
    }

    private function getNews()
    {
        $test = "hi";
    }


    private function translateNews()
    {
    }
}
