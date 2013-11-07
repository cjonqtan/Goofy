<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $goofy variable with its defaults.
include(__DIR__.'/config.php'); 


// Do it and store it all in variables in the Anax container.
$goofy['title'] = "Hem";

$goofy['main'] = <<<EOD
<section  class="border-right" >
<h1>Hej Världen!</h1>
<p>Mitt namn är Jonatan Carlsson och är 19 år gammal. Jag kommer ifrån en liten by utanför Varberg som heter Veddige. Den 28 augusti flyttade jag ner till Karlskrona för att börja plugga webbprogrammering på Blekinges Tekniska Högskola.</p>
</section>
EOD;


// Finally, leave it all to the rendering phase of Anax.
include(ANAX_THEME_PATH);
