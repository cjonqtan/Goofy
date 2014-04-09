<?php

include __DIR__.'/config.php';

$Cuser = new CUser($goofy['database']);

$goofy['title'] = isset($_SESSION['user']) ? "Logga ut" : "Logga in";

$goofy['main'] =<<<EOD
EOD;

include GOOFY_THEME_PATH;