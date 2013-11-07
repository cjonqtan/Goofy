<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Include the essential config-file which also creates the $goofy variable with its defaults.
include(__DIR__.'/config.php'); 


// Do it and store it all in variables in the Anax container.
$goofy['title'] = "Redovisningar";

$goofy['main'] = <<<EOD
<section  class="border-right" >
	<div class="post-holder">
		<header class="post-head">
			<div class="post-title">
				<h3 id="kmom01"><a href="#">Kmom01</a></h3>
			</div>
			<div class="post-meta">
				<p>2013-10-04 15:30</p>
			</div>
		</header>
		<article class="post-content">
			<p>Redovisning här</p>
		</article>
		<footer class="post-foot">
			<div class="byline">Skriven av <a href="#">Jonatan Karlsson</a></div>			
		</footer>
	</div>
</section>
EOD;


// Finally, leave it all to the rendering phase of Anax.
include(ANAX_THEME_PATH);
