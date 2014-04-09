<?php
include __DIR__.'/config.php';
//include_once GOOFY_INSTALL_PATH . '/theme/functions.php';
/*
$nav['navbar'] = array(
	'items' => array(
		'show-all' => array('text' => 'Visa alla', 'url' => '/page.php'),
		'create' => array('text' => 'Skapa ny post/sida', 'url' => null),
	),
	'callback_selected' => function($url) {
		if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
		return true;
		}
	}
);
$navbar = get_navbar($nav['navbar']);
*/
$content = new CContent($goofy['database']);
$navbar = null;
if(isset($_POST['doCreate'])) {
	$content->create($_POST);
}


$page = isset($_GET['page']) ? $_GET['page'] : "show";

switch($page) {
	case 'create':
		$goofy['title'] = "Skapa ny";

		$html = $content->getCreateForm();
		break;
default:
case 'show':
		$goofy['title'] = "Visa alla";

		$html = "Hello world";

		break;

}
$goofy['main'] = <<<EOD
{$navbar}
{$html}
EOD;

include GOOFY_THEME_PATH;