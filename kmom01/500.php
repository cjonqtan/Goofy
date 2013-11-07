
<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $goofy variable with its defaults.
include(__DIR__.'/config.php'); 



// Do it and store it all in variables in the Anax container.
$goofy['title'] = "500";
$goofy['main'] = "
<h1>Error 500</h1>
<p>Internal Server Error</p>";

// Send the 500 header 
header('HTTP/1.1 500 Internal Server Error');


// Finally, leave it all to the rendering phase of Anax.
include(ANAX_THEME_PATH);
