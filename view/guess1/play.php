<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<h1>Guess my number 1</h1>
<p>I have generated a number between 1 and 100. You have 6 tries to guess it.</p>
<div class="guess-form">
<?php if ($gameWon) : ?>
    <h2>You won!</h2>
    <form method="post" action="reset">
        <input type="submit" name="reset" value="Play again">
    </form>
<?php else : ?>
    <?php if (!$outOfGuesses) : ?>
        <form method="post" action="guess">
            <input type="number" name="input">
            <input type="submit" name="guess" value="Guess">
        </form>
        <form method="post" action="reset">
            <input type="submit" name="reset" value="Reset game">
        </form>
        <form method="post" action="cheat">
            <input type="submit" name="cheat" value="Cheat">
        </form>
    <?php else : ?>
        <h2>OUT OF GUESSES!</h2>
        <form method="post" action="reset">
            <input type="submit" name="reset" value="Reset game">
    </form>
    <?php endif; ?>
<?php endif; ?>
</div>
<h2>Tries left: <?=strval($guess->tries())?></h2>
<?php
if ($exception) {
        echo "<p> EXCEPTION: ";
        echo $exception;
        echo "</p>";
        unset($_SESSION['exception']);
} elseif ($guessMade) {
        echo "<h2>Your guess result: ";
        echo $guessMade;
        echo "</h2>";
        unset($_SESSION['guessMade']);
}

if ($cheat) {
    echo "<h2> The number you're looking for is: ";
    echo $cheat;
    echo "</h2>";
    unset($_SESSION['cheat']);
}
