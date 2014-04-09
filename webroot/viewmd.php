<?php

require __DIR__.'/config.php';

define('DIRECTORY',__DIR__.'/markdownfiles');
if ($handle = opendir(__DIR__)) {

	$dir = readdir($handle);
	var_dump($dir);
	$html = "<ul>";
 	while ($entry = readdir($handle)) {
        $html .= "<li>". $entry ."</li>";
    }

	$files = glob("*.md");
	
	foreach ($files as $file) {
		
	}
	$html .= "</ul>";
	$goofy['main'] = $html;
}
require GOOFY_THEME_PATH;