<?php 
/**
 * This is a Goofy pagecontroller.
 *
 */
// Include the essential config-file which also creates the $goofy variable with its defaults.
include(__DIR__.'/config.php'); 



// Do it and store it all in variables in the Goofy container.
$goofy['title'] = "403";
$goofy['main'] = "
<h1>Error 403</h1>
<p>Forbidden.</p>";

// Send the 403 header 
header('HTTP/1.0 403 Forbidden');


// Finally, leave it all to the rendering phase of Goofy.
include(GOOFY_THEME_PATH);
