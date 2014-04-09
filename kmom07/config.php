<?php
/**
 * Config-file for Goofy. Change settings here to affect installation.
 *
 */

/**
 * Set the error reporting.
 *
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly
define('DEBUG', true);			  // if true thrown errors will be visible

/**
 * Define Goofy paths.
 *
 */
define('GOOFY_INSTALL_PATH', __DIR__ . '/..');
define('GOOFY_THEME_PATH', GOOFY_INSTALL_PATH . '/theme/render.php');



/**
 * Include bootstrapping functions and dbconfig.
 * 
 */
include(GOOFY_INSTALL_PATH . '/src/bootstrap.php');
include(GOOFY_INSTALL_PATH . '/src/dbconfig.php');


/**
 * Start the session.
 *
 */
session_name(preg_replace('/[:\.\/-_]/', '', __DIR__));
session_start();

$goofy = array();

/**
 * Site wide settings.
 *
 */
$goofy['lang'] = 'sv';
$goofy['title_append'] = ' | RM Rental Movies';
// Default title 
$goofy['title'] = "Goofy";

$goofy['header'] = <<<EOD
<img class='sitelogo' src='img.php?src=logo.jpg&amp;h=100' alt='Goofy Logo'/>
<span class='sitetitle'>RM Rental Movies</span>
<span class='siteslogan'>Hyr filmer, enkelt!</span>
EOD;

$goofy['navbar'] = array(
	'class' => '',
	'items' => array(
		'hem' => array('text'=>'Hem ',  'url'=>'index.php'),
		'nyheter' => array('text' => 'Nyheter ', 'url' => 'news.php'),		
		'hyr' => array('text' => 'Hyr film ', 'url' => 'movie.php'),
		'adminpanel' => array('text' => isset($_SESSION['user']) ? 'Adminpanel ' : null, 'url' => isset($_SESSION['user']) ? 'adminpanel.php' : null),
		
		'om' => array('text'=>'Om ',  'url'=>'about.php'),
		'login' => array('text' => isset($_SESSION['user']) ? 'Logga ut' :'Logga in' , 'url' =>  isset($_SESSION['user']) ? 'logout.php' : 'login.php'),
		//'kallkod' => array('text'=>'Källkod', 'url'=>'source.php'),
	),
	'callback_selected' => function($url) {
		if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
		return true;
		}
	}
);
// Default body
$goofy['main'] = <<<EOD
<h1>Goofy webbtemplate</h1><p>Återanvändbara moduler för webbutveckling med PHP</p>
EOD;

$goofy['footer'] = <<<EOD
<div class="center-text">
RM Rental Movies &copy; 2014
</div>
EOD;

$goofy['stylesheets'][] = 'css/standard.min.css';
$goofy['stylesheets'][] = 'css/style.css';

$goofy['inlinestyle'] = null;

$goofy['favicon']    = 'favicon.ico';



/**
 * Settings for JavaScript.
 *
 */
//$goofy['modernizr'] = 'js/modernizr.js';
$goofy['modernizr'] = null;
//$goofy['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
$goofy['jquery'] = null; // To disable jQuery
//$goofy['javascript_include'] = array();


/**
 * Settings for the database.
 * Constants is defined in dbconfig.php
 */
$goofy['database']['dsn']            = DB_DSN;
$goofy['database']['username']       = DB_USER;
$goofy['database']['password']       = DB_PASSWORD;
$goofy['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");