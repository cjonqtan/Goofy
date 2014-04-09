<?php

include __DIR__ .'/config.php';
$CMovie = new CMovie($goofy['database']);
$CUser = new CUser($goofy['database']);

if(isset($_POST['doRent'])) {
	echo "<script>alert('{$_POST['movie-name']} skickas nu hem till dig!')</script>";

}

// Säkerhets koll så att man inte kan söka på en tom string
if(isset($_POST['title']) && empty($_POST['title'])) {
	header("Location: http://www.student.bth.se/~jokd13/oophp/kmom07/movie.php");
}


$breadcrumb = "<div id='breadcrumb'><a href='movie.php'>Filmer</a>";
$formValue = null;

// Breadcrumb start 
	$slug = isset($_GET['slug'])  ? strip_tags($_GET['slug']) : null;

	if(!is_null($slug)) {
		$slug = " WHERE slug='" . $slug . "'"; 

		$sql = "SELECT title, slug FROM Movie_kmom07 {$slug}";

		$data = $CMovie->Select($sql);

		$breadcrumb .= "<a href='movie.php?slug={$data[0]->slug}'>{$data[0]->title}</a>";
	}
	$breadcrumb .= "</div>";
// Breadcrumb end

$goofy['title'] = "Hyr filmer";

$sidebar = null;
$html = null;
$slug = isset($_GET['slug']) ? strip_tags($_GET['slug']) : null;
$tf = false;


if(!is_null($slug) || (isset($_POST['title']) && !is_null($_POST['title']))) {
	if(isset($_POST['title']) && !empty($_POST['title'])) {
		$title = strip_tags($_POST['title']);
		$data = $CMovie->getSearch($title);

	} else {
		$data = $CMovie->getMovies($slug);
	}
	foreach ($data as $key => $value) {

	$html .= <<<EOD
	<div class="border-all">
		<form method="post" style="background:#eee">
		<input type="hidden" name="movie-name" value="{$value->title}">
			<div class="clearfix padding-all" >
				<a class="right" href="movie.php">Tillbaka</a>
				<div class="left">
					<img src="img.php?src=movies/{$value->image}&amp;w=475&amp;h=302" alt="{$value->title}">
				</div>
				<div class="left" style="width:500px;">
					<ul style="list-style: none;">
						<li>Title: {$value->title}</li>
						<li>Längd: {$value->length} min</li>
						<li>Från: {$value->year}</li>
						<li>Regissör: {$value->director}</li>
						<li>Trailer: <a href="{$value->trailer}" target="_blank">Här</a></li>
						<li>Pris: {$value->price} SEK</li>
						<li><input type="submit" name="doRent" value="Hyr"></li>
					</ul>
				</div>
			</div>
			<div class="padding-all clearfix">
				<h2 class="text-left">Handling</h2>
				<hr style="border-bottom:3px solid #eee;">
				<p class="justify-text">{$value->plot}</p>
			</div>
		</form>
		</div>
EOD;
	}

} else {
	$html = "<main id='content'><article>";
	$admin = null;
	$data = $CMovie->getForFront(null, "title");

	foreach ($data as $key => $value) {
		if($CUser->isUserLoggedIn()) {
			$admin = " <small><a class='text-right' href='adminpanel.php?p=movie&amp;id={$value->id}'>Editera</a></small>";
		}
		$html .= <<<EOD
		<div class="movie-holder">
			<div class="left"><a href='movie.php?slug={$value->slug}'><img src="img.php?src=movies/{$value->image}&amp;h=300&amp;w=202" alt="{$value->title}"></a></div>
			<div class="text-holder"><h3 class="center-text">{$value->title}{$admin}</h3><p>{$value->plot}</p><p><a href="movie.php?slug={$value->slug}">Mer info >></a></div>
		</div>
EOD;
	}

	$html .= "</article></main>";

	$sidebar = <<<EOD
	<div id="sidebar">
		<form method="post">
			<p><label>Sök</label></p>
			<p><input style="width:100%;" type="text" name="title" {$formValue} placeholder="Sök title"></p>
			<p><input type="submit" name="doSearch" value="Sök"></p>
		</form>
	</div>
EOD;
}

$goofy['main'] = <<<EOD
{$breadcrumb}
{$html}
{$sidebar}
EOD;


include GOOFY_THEME_PATH;