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
$goofy['title_append'] = ' | Goofy webbtemplate';
// Default title 
$goofy['title'] = "Goofy";

$goofy['header'] = <<<EOD
<img class='sitelogo' src='img.php?src=goofy.jpg&amp;h=100' alt='Goofy Logo'/>
<span class='sitetitle'>Goofy webbtemplate</span>
<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>
EOD;

$goofy['navbar'] = array(
	'class' => '',
	'items' => array(
		'home' => array('text'=>'Home ',  'url'=>'index.php'),
//		'about' => array('text'=>'About ',  'url'=>'about.php'),
//		'kallkod' => array('text'=>'Source', 'url'=>'source.php'),
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
<a href="https://github.com/cjonqtan/Goofy">Goofy on Github</a>
EOD;

$goofy['stylesheets'][] = 'css/standard.min.css';
$goofy['stylesheets'][] = 'css/style.css';

$goofy['inlinestyle'] = null;

$goofy['favicon']    = 'img/favicon.ico';



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
 * Constants is defined in /src/dbconfig.php
 */
$goofy['database']['dsn']            = DB_DSN;
$goofy['database']['username']       = DB_USER;
$goofy['database']['password']       = DB_PASSWORD;
$goofy['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
