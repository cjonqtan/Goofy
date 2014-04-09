<?php 

// Include the essential config-file which also creates the $goofy variable with its defaults.
include(__DIR__.'/config.php'); 
/*
$goofy['stylesheets'][]        = 'css/slideshow.css';
$goofy['javascript_include'][] = 'js/slideshow.js';
*/

$Ccontent = new CContent($goofy['database']);
$CMovie = new CMovie($goofy['database']);

$sidebar = $Ccontent->getContent('post',null, 3);

$data = $CMovie->getForFront(3);

$html = "<article><header><h4>Senast tilllagda filmer</h4>";
foreach ($data as $key => $value) {
$html .= <<<EOD
<div class="movie-holder">
	<div class="left"><a href='movie.php?slug={$value->slug}'><img src="img.php?src=movies/{$value->image}&amp;h=300&amp;w=202" alt="{$value->title}"></a></div>
	<div class="text-holder"><h3 class="center-text">{$value->title}</h3><p>{$value->plot}</p><p><a href="movie.php?slug={$value->slug}">Mer info >></a></div>
</div>
EOD;
}

$html .= "</article>";
$content = null;

$goofy['title'] = "Hem";

$goofy['main'] = <<<EOD

<main id="content">
{$html}

</main>
<div id='sidebar'">
<header><h4>Senaste nytt</h4></header>
{$sidebar}
</div>
EOD;
/*
$goofy['sidebar'] = <<<EOD

EOD;*/

// Finally, leave it all to the rendering phase of Goofy.
include(GOOFY_THEME_PATH);
