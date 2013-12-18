<?php
/**
 * This is a Goofy pagecontroller.
 *
 */
include __DIR__.'/config.php';
$html = null;

// Create object or get it from session
$round = isset($_SESSION['round']) ? $_SESSION['round'] : new CDiceGame();


$dice = new CDiceImage();

if(isset($_POST['Save'])) {
    // if player saves.
    $round->increaseTotal();
    $round->increaseRound();
    $html .= '<p>Du har sparat ' . $round->total . ' på ' . $round->round . ' omgångar</p>';
    $round->resetScore();
    // check if player won
    if($round->total > 99) {
        $html .= '<p> DU HAR VUNNIT!!! TOTAL ÄR 100!!!!!';
        $round = new CGameRound();
        $_SESSION['round'] = $round; 
    }
}
if(isset($_POST['Throw'])) {
    // If player throws the dice
    $dice->Roll(1);
    $roll = $dice->getLastRoll();
    if($roll == 1) {
        // player lost his points
        $html .= $dice->GetRollsAsImageList();
        $html .= '<p>Du fick en etta... Du förlorade alla poäng denna rundan.';
        $round->ResetScore();
        $round->increaseRound();
    } else {
        $round->increaseScore($roll);
        $_SESSION['round'] = $round;
        $html .= $dice->GetRollsAsImageList();

        $html .= '<p>' . $round->score . ' poäng </p> <p>Du har sammanlagt ' . $round->total . ' poäng';
        $html .= ' på ' . $round->round . ' omgångar. </p>';
    }
}

if(isset($_POST['Reset'])) {
    unset($_SESSION['round']);
    $round = new CDiceGame();
}


$html .= '<form method="post">
<input type="submit" name="Throw" value="Kasta">
<input type="submit" name="Save" value="Spara">
<input type="submit" name="Reset" value="Starta om spel">
</form>';

// Sets the html page...
$goofy['title'] = "Tärningsspelet 100";
$goofy['stylesheets'][] = "css/dice.css";

$goofy['main'] = <<<EOD
<h1>Tärningsspelet</h1>
<p>Tärningsspelet 100 är ett enkelt, men roligt, tärningsspel. Det gäller att samla ihop poäng för att komma först till 100. I varje omgång kastar en spelare tärning tills hon väljer att stanna och spara poängen eller tills det dyker upp en 1:a och hon förlorar alla poäng som samlats in i rundan. </p>
{$html}
EOD;
include GOOFY_THEME_PATH;