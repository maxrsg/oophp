<?php

namespace Anax\View;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

$session = $app->session;
?>
<h1>Dice 100</h1>
<p>Första till 100 vinner!</p>
<div class="game-area">
    <div class="dice100-player">
    <h4>Spelare: <?= $session->get('playerTotal')?></h4>

    </div>
    <div class="dice100-computer">
    <h4>Datorn: <?= $session->get("computerTotal")?></h4>
    <!-- <?php var_dump($session); ?> -->
    </div>
    <?php if ($session->get('gameOver') == false) : ?>
        <div class="dice100-results">
            <h4>Spelare: <?= $session->get('currentPlayer') ?></h4>
            <p><b>Senaste kast</b></p>
            <p>Tärningar: <?= $session->get('dices') ?> </p>
            <p>Poäng: <?= $session->get('currentScore') ?></p>
        </div>
        <div class="dice100-buttons">
            <?php if ($session->get('computerPlaying') == false) : ?>
                <form method="post" action="roll">
                    <input type="submit" name="roll" value="Kasta">
                </form>
                <?php if ($session->get('hasRolled') == true) : ?>
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
        <h2><?= $session->get("gameOver") ?> won</h2>
        <form method="post" action="reset">
            <input type="submit" name="reset" value="Reset">
        </form>
    <?php endif; ?>
    <?php $histogram = $app->request->getPost("histogram") ?>
    <?php var_dump($histogram)?>
<?php if ($histogram) : ?>
    <h1>Display a histogram</h1>
    <p><?= implode(", ", $histogram->getSerie()) ?></p>
    <pre><?= $histogram->getAsText() ?></pre>
    </div>
<?php endif; ?>