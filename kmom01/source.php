<?php 

include(__DIR__.'/config.php'); 


$source = new CSource();


$goofy['title'] = "Källkod";
$goofy['inlinestyle'] = <<<EOD
#main-content {margin-left: 0px;	width:auto;}
EOD;
$goofy['stylesheets'][] = "css/source.css";


$goofy['main'] = $source->View();


// Finally, leave it all to the rendering phase of Anax.
include(ANAX_THEME_PATH);
