<?php

namespace Anax\View;

?>
<h1>Dice 100</h1>
<p>Första till 100 vinner!</p>
<div class="game-area">
    <div class="dice100-player">
    <h4>Spelare: <?= $_SESSION['playerTotal']?></h4>

    </div>
    <div class="dice100-computer">
    <h4>Datorn: <?= $_SESSION['computerTotal']?></h4>
    <!-- <?php var_dump($_SESSION); ?> -->
    </div>
    <?php if ($_SESSION['gameOver'] == false) : ?>
        <div class="dice100-results">
            <h4>Spelare: <?= $_SESSION['currentPlayer'] ?></h4>
            <p><b>Senaste kast</b></p>
            <p>Tärningar: <?= $_SESSION['dices'] ?> </p>
            <p>Poäng: <?= $_SESSION['currentScore'] ?></p>
        </div>
        <div class="dice100-buttons">
            <!-- <p><?= var_dump($_SESSION['dice100']) ?></p> -->
            <?php if ($_SESSION['computerPlaying'] == false) : ?>
                <form method="post" action="roll">
                    <input type="submit" name="roll" value="Kasta">
                </form>
                <?php if ($_SESSION['hasRolled'] == true) : ?>
                    <form method="post" action="save">
                        <input type="submit" name="save" value="Spara">
                    </form>
                <?php else : ?>
                    <form method="post" action="save">
                        <input type="submit" name="save" value="Spara" disabled>
                    </form>
                <?php endif; ?>
                <form method="post" action="reset">
                    <input type="submit" name="reset" value="Reset">
                </form>
            <?php else : ?>
                <form method="post" action="save">
                    <input type="submit" name="save" value="Låt datorn spela">
                </form>
                <form method="post" action="reset">
                    <input type="submit" name="reset" value="Reset">
                </form>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <h2><?= $_SESSION['gameOver'] ?> won</h2>
    <?php endif; ?>
</div>