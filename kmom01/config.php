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
$goofy['title_append'] = ' | oophp';

$goofy['header'] = <<<EOD
<h1><a href="index.php">Jonatan Karlsson</a></h1>
<h4>Ska det kodas så ska det kodas ordentligt!</h4>
EOD;



$goofy['navbar'] = array(
	'class' => '',
	'items' => array(
		'hem' => array('text'=>'Hem',  'url'=>'index.php'),
		'redovisning' => array('text'=>'Redovisning', 'url'=>'report.php'),
		'kallkod' => array('text'=>'Källkod', 'url'=>'source.php'),
	),
	'callback_selected' => function($url) {
		if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
		return true;
		}
	}
);
$goofy['footer'] = <<<EOD
<a target="_blank" href="http://www.jonatankarlsson.se">Jonatan Karlsson &copy; 2013</a>
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
 * Google analytics.
 *
 */
