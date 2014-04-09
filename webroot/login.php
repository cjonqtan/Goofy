<?php
include __DIR__.'/config.php';

$CUser = new CUser($goofy['database']);
if($CUser->isUserLoggedIn()) {
	header("Location: index.php");
}

if(isset($_POST['doLogin'])) {
	$CUser->login($_POST);
}

$errors = null;

if(isset($_GET['error'])) {
	$errors = "<p>Fel användarnamn eller lösenord</p>";
}

$goofy['title'] = "Logga in";

$goofy['main'] =<<<EOD
<h2>Logga in</h2>
<form method='post'>
<p><input type="text" name="username" placeholder="Användarnamn" requierd></p>
<p><input type="password" name="password" placeholder="Lösenord" requierd></p>
<p><input type="submit" name="doLogin" value="Logga in"></p>
</form>
{$errors}
EOD;


include GOOFY_THEME_PATH;