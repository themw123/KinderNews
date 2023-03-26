<?php
//achtung immer absolute pfade angeben sonnst probleme!!!!
require_once("/var/www/html/vendor/autoload.php");
require_once("/var/www/html/klassen/DbFunctions.inc.php");
require_once("/var/www/html/klassen/Request.inc.php");

require_once("/home/config.php");
require_once("/home/News.inc.php");




$news = new News();
