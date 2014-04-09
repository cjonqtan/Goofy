<?php

include __DIR__.'/config.php';

$CUser = new CUser($goofy['database']);

$goofy['title'] = isset($_SESSION['user']) ? "Logga ut" : "Logga in";

$error = isset($_GET['error']) ? "<p> Fel användarnamn eller lösenord</p>" : null;

if(isset($_SESSION['user']) || $CUser->isUserLoggedIn() ) {
	$html = "<p>Du är redan inloggad</p>";
} else {
	$html = <<<EOD
	{$error}
	<form method='post'>
		<input type="username" name="username" placeholder="Username">
		<input type="password" name="password" placeholder="Password">
		<input type="submit" name="login" value="Logga in">
	</form>
EOD;

}

if(isset($_GET['logout'])) {
	$CUser->logout();
}

if(isset($_POST['login'])) {
	$CUser->login($_POST);
}

$goofy['main'] =<<<EOD
{$html}
EOD;

include GOOFY_THEME_PATH;