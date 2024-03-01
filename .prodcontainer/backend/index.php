<?php
//achtung immer absolute pfade angeben sonnst probleme!!!!
require_once("/var/www/html/vendor/autoload.php");
require_once("/var/www/html/klassen/db/DBHelper.inc.php");
require_once("/var/www/html/klassen/db/DBNews.inc.php");
require_once("/var/www/html/klassen/Request.inc.php");

require_once("/backend/config.php");
require_once("/backend/News.inc.php");




$news = new News();
