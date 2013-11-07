<?php 
/**
 * This is a Goofy pagecontroller.
 *
 */

// Include the essential config-file which also creates the $goofy variable with its defaults.
include(__DIR__.'/config.php'); 


// Do it and store it all in variables in the Goofy container.
$goofy['title'] = "Redovisningar";

$goofy['main'] = <<<EOD
<section  class="border-right" >
	<div class="post-holder">
		<header class="post-head">
			<div class="post-title">
				<h2 id="kmom01"><a href="#">Kmom01</a></h2>
			</div>
			<div class="post-meta">
				<p>2013-11-07 15:49</p>
			</div>
		</header>
		<article class="post-content">
			<p>Tyckte detta momentet var lagom svår att börja med. Det tog mig  lite tid innan jag förstod hur denna webbmallen var uppbyggd. Men när jag hajade det så var 
			det inga problem. Var inga konstigheter att includera CSource heller.
			<p>Jag använde mig av ett gammal blogg-stylesheet som jag hittade hade liggande i mitt bibliotek. Lade även in min "standard"-style som är ett stylesheet som jag ställer in basic inställningar på mina sidor.
			<p>Tycker upplägget av mapstrukturen är riktigt nice. Tycker det är helt rätt att lägga ut classerna utanför webbrooten. Skulle vilja lägga in en config-fil med databas -lösenord och -användarnamn
			i source-mappen. Vet inte hur det blir senare, när vi kommer till databaser, om vi har det i config-fil i webbrooten eller i en egen configf-il i source-mappen? Det återstår att se antar jag. 
			<h3>Min utvecklingsmiljö </h3>
			<p>När jag är hemma och utvecklar så sitter jag på Arch Linux med Cinnamon som DE. Och när jag sitter på lapptopen så är de Xubuntu. Använder mig av Sublime text 2 och använder även den som FTP-client.
			När vi kommer till webbläsare använder jag mig av borde Chrome och Firefox. 
			<p>Namnet på min webbmall blev Goofy, efter Långben såklart. Jag gjorde ett konto på <a target="_blank" href="https://github.com/cjonqtan/Goofy">Github</a> och lade upp Goofy där. 
		</article>
		<footer class="post-foot">
			<div class="byline">Skriven av <a href="#">Jonatan Karlsson</a></div>			
		</footer>
	</div>
</section>
EOD;


// Finally, leave it all to the rendering phase of Goofy.
include(GOOFY_THEME_PATH);