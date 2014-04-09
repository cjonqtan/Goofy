<?php
include __DIR__ .'/config.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

$CContent = new CContent($goofy['database']);

$breadcrumb = "<div id='breadcrumb'><a href='news.php'>Nyheter</a>";

$slug = isset($_GET['slug'])  ? strip_tags($_GET['slug']) : null;

if(!is_null($slug)) {
	$slug = " WHERE slug='" . $slug . "'"; 

	$sql = "SELECT title, slug FROM Content_kmom07 {$slug}";

	$data = $CContent->Select($sql);

	$breadcrumb .= "<a href='news.php?slug={$data[0]->slug}'>{$data[0]->title}</a>";
}
$breadcrumb .= "</div>";

// lol hämtar slug en gång till
$slug = isset($_GET['slug'])  ? strip_tags($_GET['slug']) : null;

$content = $CContent->getContent('post', $slug, 10,20);
$goofy['title'] = "Nyheter";
$goofy['main'] = <<<EOD
{$breadcrumb}
<main>
	{$content}
</main>
EOD;

include GOOFY_THEME_PATH;