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


/**
 * Define Goofy paths.
 *
 */
define('GOOFY_INSTALL_PATH', __DIR__ . '/..');
define('GOOFY_THEME_PATH', GOOFY_INSTALL_PATH . '/theme/render.php');



/**
 * Include bootstrapping functions.
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
$goofy['title_append'] = ' | Goofy webbtemplate';

$goofy['header'] = <<<EOD
<img class='sitelogo' src='img/goofy.jpg' alt='Anax Logo'/>
<span class='sitetitle'>Goofy webbtemplate</span>
<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>
EOD;

$goofy['navbar'] = array(
	'class' => '',
	'items' => array(
		'hem' => array('text'=>'Hem',  'url'=>'index.php'),
		'redovisning' => array('text'=>'Redovisning', 'url'=>'report.php'),
		'Träningsspelet' => array('text'=>'Träningsspelet', 'url'=>'dice.php'),
		'Filmdatabasen' => array('text'=>'Filmdatabasen', 'url'=>'movie.php'),
		'kallkod' => array('text'=>'Källkod', 'url'=>'source.php'),
	),
	'callback_selected' => function($url) {
		if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
		return true;
		}
	}
);
$goofy['footer'] = <<<EOD
<div class="center-text">
<a target="_blank" href="http://www.jonatankarlsson.se">Jonatan Karlsson</a> &copy; 2013</div>
EOD;

$goofy['stylesheets'][] = 'css/standard.min.css';
$goofy['stylesheets'][] = 'css/style.css';

$goofy['inlinestyle'] = null;

$goofy['favicon']    = 'favicon.ico';



/**
 * Settings for JavaScript.
 *
 */
$goofy['modernizr'] = 'js/modernizr.js';
$goofy['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
//$goofy['jquery'] = null; // To disable jQuery
$goofy['javascript_include'] = array();


/**
 * Settings for the database.
 *
 */
$goofy['database']['dsn']            = 'mysql:host=blu-ray.student.bth.se;dbname=jokd13;';
$goofy['database']['username']       = DB_USER;
$goofy['database']['password']       = DB_PASSWORD;
$goofy['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");