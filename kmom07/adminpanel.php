<?php 
include __DIR__ .'/config.php';

$_SESSION['auth'] = !isset($_SESSION['auth']) ? $_SESSION['auth'] : 0; 


$CContent = new CContent($goofy['database']);
$CUser = new CUser($goofy['database']);
$CMovie = new CMovie($goofy['database']);w

if(isset($_POST['createMovie'])) {
	$CMovie->createMovie($_POST);
}

if(isset($_POST['createPost'])) {
	$CContent->createPost($_POST);
}

if(isset($_POST['doEditMovie'])){
	$CMovie->editMovie($_POST);
}

if(isset($_POST['removeMovie'])) {
	$CMovie->removeMovie($_POST['id']);
	header("Location: http://www.student.bth.se/~jokd13/oophp/kmom07/adminpanel.php?p=remove-movie");
	exit();
}
if(isset($_POST['removePost'])) {
	$CContent->removePost($_POST['id']);
	header("Location: http://www.student.bth.se/~jokd13/oophp/kmom07/adminpanel.php?p=remove-post");
	exit();
}
$sidebar = <<<EOD
<ul>
	<li><a href="adminpanel.php?p=add-post">Lägg till nyhet </a></li>
	<li><a href="adminpanel.php?p=post">Editera nyheter</a></li>
	<li><a href="adminpanel.php?p=remove-post">Tabort nyhet</a></li>
	<li><a href="adminpanel.php?p=add-movie">Lägg till film</a></li>
	<li><a href="adminpanel.php?p=movie">Editera film</a></li>
	<li><a href="adminpanel.php?p=remove-movie">Tabort film</a></li>
</ul>
EOD;

if(!$CUser->isUserLoggedIn()) {
	header('Location: http://www.student.bth.se/~jokd13/oophp/kmom07/login.php');
}

$title = null;
$content = null;
$footer = null;
$page = isset($_GET['p']) ? strip_tags($_GET['p']) : null;

switch ($page) {
	case 'add-movie':
		$title = "Lägg till film";
		$content = $CMovie->getForm();
		break;

	case 'add-post':
		$title = "Skapa ny blogg-post";
		$content = $CContent->getBloggForm();
		break;
	case 'remove-post':
		$title = "Tabort nyhet";
		if(!isset($_GET['id'])) {
			$sql = "SELECT title, slug,id FROM Content_kmom07 WHERE deleted <> 1";
			$data = $CMovie->Select($sql);
			$html = "<ul>";
			foreach ($data as $key => $value) {
				$html .= "<li><a href='adminpanel.php?p=remove-post&id={$value->id}'>{$value->title}</a></li>";
			}
			$html .= "</ul>";
			$content = $html;
		} else {				
			$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : die();
			$Sql = "SELECT * FROM Content_kmom07 WHERE id=?";
			$data = $CMovie->Select($Sql,array($_GET['id']),true);
			
			$content =	"<h2>{$data[0]->title}</h2><div style='min-height:200px;' class='clearfix'><form method='post'><input type='hidden' value='{$data[0]->id}' name='id'><input type='checkbox' requierd><input type='submit' name='removePost' value='Tabort nyhet'></form></div>";	
		}
		break;
	default:
	case 'movie': 
		$title = "Editera movie";
		if(!isset($_GET['id'])) {
			$sql = "SELECT title, slug,id FROM Movie_kmom07 ";
			$data = $CMovie->Select($sql);
			$html = "<ul>";
			foreach ($data as $key => $value) {
				$html .= "<li><a href='adminpanel.php?p=movie&id={$value->id}'>{$value->title}</a></li>";
			}
			$html .= "</ul>";
			$content = $html;
		} else {				
			$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : die();
			$Sql = "SELECT * FROM Movie_kmom07 WHERE id=?";
			$data = $CMovie->Select($Sql,array($id));
			$content = $CMovie->getEditForm($data);	
		}
		break;
	case 'remove-movie':
		$title = "Tabort film";
		if(!isset($_GET['id'])) {
			$sql = "SELECT title, slug,id FROM Movie_kmom07 WHERE deleted <> 1";
			$data = $CMovie->Select($sql);
			$html = "<ul>";
			foreach ($data as $key => $value) {
				$html .= "<li><a href='adminpanel.php?p=remove-movie&id={$value->id}'>{$value->title}</a></li>";
			}
			$html .= "</ul>";
			$content = $html;
		} else {				
			$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : die();
			$Sql = "SELECT * FROM Movie_kmom07 WHERE id=?";
			$data = $CMovie->Select($Sql,array($_GET['id']));
			
			$content =	"<h2>{$data[0]->title}</h2><div style='min-height:200px;' class='clearfix'><form method='post'><input type='hidden' value='{$data[0]->id}' name='id'><input type='checkbox' requierd><input type='submit' name='removeMovie' value='Tabort film'></form></div>";	
		}
		break;
	case 'post':
	 	$title = "Editera movie";

		if(!isset($_GET['id'])) {
			$sql = "SELECT title, slug,id FROM Content_kmom07  WHERE deleted <> 1 ";
			$data = $CContent->Select($sql);
			$html = "<ul>";
			foreach ($data as $key => $value) {
				$html .= "<li><a href='adminpanel.php?p=post&id={$value->id}'>{$value->title}</a></li>";
			}
			$html .= "</ul>";
			$content = $html;
		} else {				
			$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : die();
			$Sql = "SELECT * FROM Content_kmom07 WHERE id=?";
			$data = $CContent->Select($Sql,array($id));
			$content = $CContent->getEditForm($data);	
		}
		break;
		break;
}

$goofy['title'] = $title;

$goofy['main'] = <<<EOD

<header>
	<h1>{$title}</h1>
</header>
<main id='content'>
<article style='min-height:20em'>
	{$content}
</article>
<footer>
	{$footer}
</footer>
</main>
{$sidebar}
EOD;


include GOOFY_THEME_PATH;