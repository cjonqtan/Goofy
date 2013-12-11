<?php 
/**
 * This is a Goofy pagecontroller.
 *
 */
// Include the essential config-file which also creates the $goofy variable with its defaults.
include(__DIR__.'/config.php'); 



// Do it and store it all in variables in the Goofy container.
$goofy['title'] = "404";
$goofy['main'] = "
<h1>Error 404</h1>
<p>Sidan du söker efter finns inte.</p>";

// Send the 404 header 
header("HTTP/1.0 404 Not Found");


// Finally, leave it all to the rendering phase of Goofy.
include(GOOFY_THEME_PATH);
