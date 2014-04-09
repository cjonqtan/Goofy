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
<section class="border-left border-right" >
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
			<div class="byline">Skriven av <a target="_blank" href="http://www.jonatankarlsson.se">Jonatan Karlsson</a></div>			
		</footer>
	</div>
	<div class="post-holder">
		<header class="post-head">
			<div class="post-title">
				<h2 id="kmom02"><a href="#">Kmom02</a></h2>
			</div>
			<div class="post-meta">
			</div>
		</header>
		<article class="post-content">
			<p>Jag gillar starkt att jobba med objektorienterad struktur. Tycker de är mycket smidigt då man separerar "logiken" och htmlen på ett bra sätt. Har jobbat en del med OOP i andra språk och måste säga att desto mer man jobbar med det destu bättre tycker man om det. Tror den objektorienterad strukturen är hur bra som helst när man jobbar i grupp. För då kan man dela upp arbetet på ett enkelt sätt.</p>
			<p>Jag läste igenom "oophp 20 steg" guiden, gjorde delar som jag tyckte va intressant men inte mer än så. Tyckte den tog upp de mesta, allafall de som jag kan tänka mig. </p>
			<p>Jag valde att göra träningsspelet då vi gjorde månadens babe på labben.</p>
	<p> När jag gjorde träningsspelet så tog jag lite av mos exempel från "20 steg guiden", sen utveckla jag det lite med CDiceImage som fixar fram en fin bild beroende på va diceFace har för värde. Sen var det bara att koda dice.php med lite fin game logik. Inga konstigheter tycker jag. Utan de gick rätt bra. Hade lite problem när jag bestämde mig för att byta namn på CGameRound till CGameRound, tänkte aldrig på att uppdatera dice.php så hade massa konstiga krachar ett tag. Men sen insåg jag mitt fel och fixade det. Det var ju inte det svåraste felet, måste varit trött eller något. </p>
		</article>
		<footer class="post-foot">
			<div class="byline">Skriven av <a target="_blank" href="http://www.jonatankarlsson.se">Jonatan Karlsson</a></div>			
		</footer>
	</div>
	<div class="post-holder">
		<header class="post-head">
			<div class="post-title">
				<h2 id="kmom03"><a href="#">Kmom03</a></h2>
			</div>
			<div class="post-meta">
				
			</div>
		</header>
		<article class="post-content">
			
		</article>
		<footer class="post-foot">
			<div class="byline">Skriven av <a target="_blank" href="http://www.jonatankarlsson.se">Jonatan Karlsson</a></div>			
		</footer>
	</div>
</section>
EOD;


// Finally, leave it all to the rendering phase of Goofy.
include(GOOFY_THEME_PATH);