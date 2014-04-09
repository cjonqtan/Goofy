<?php
include __DIR__ .'/config.php';

$CUser = new CUser($goofy['database']);

if($CUser->isUserLoggedIn()) {
	$CUser->logout();
} else {
	header("Location: http://www.student.bth.se/~jokd13/oophp/kmom07/login.php ");
	exit();
}

include GOOFY_THEME_PATH;