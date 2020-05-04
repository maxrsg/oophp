
<h1>Guess my number</h1>
<p>I have generated a number between 1 and 100. You have 6 tries to guess it.</p>

<?php if ($outOfGuesses == false) : ?>
    <form method="post" action="process.php">
        <input type="number" name="input">
        <input type="submit" name="guess" value="Guess">
        <input type="submit" name="reset" value="Reset game">
        <input type="submit" name="cheat" value="Cheat">
    </form>
<?php elseif ($gameWon == true) : ?>
    <h2>You won!</h2>
    <form method="post" action="process.php">
        <input type="submit" name="reset" value="Play again">
    </form>
<?php else : ?>
    <h2>OUT OF GUESSES!</h2>
    <form method="post" action="process.php">
        <input type="submit" name="reset" value="Reset game">
    </form>
<?php endif; ?>
<h2>Tries left: <?=strval($guess->tries())?></h2>
<?php
if ($guessMade || $exception) {
    if ($exception) {
        echo "<pre>";
        echo $exception;
        echo "</pre>";
        unset($_SESSION['exception']);
    } else {
        echo "<h2>Your guess result: ";
        echo $guessMade;
        echo "</h2>";
        unset($_SESSION['guessMade']);
    }
}

if ($cheat) {
    echo "<h2> The number you're looking for is: ";
    echo $cheat;
    echo "</h2>";
    unset($_SESSION['cheat']);
}
