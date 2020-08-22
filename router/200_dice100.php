<?php
/**
 * Init game and redirects to play.
 */
$app->router->get("dice100/init", function () use ($app) {
    // init session for game
    $dice100 = new Magm19\Dice100\Dice100();
    $app->session->set("dice100", $dice100);
    $app->session->set("currentScore", 0);
    $app->session->set("dices", "");
    $app->session->set("currentPlayer", $dice100->getCurrentPlayer());
    $app->session->set("playerTotal", 0);
    $app->session->set("computerTotal", 0);
    $app->session->set("changePlayer", false);
    $app->session->set("computerPlaying", false);
    $app->session->set("gameOver", false);
    $app->session->set("hasRolled", false);
    return $app->response->redirect("dice100/play");
});



/**
 * Play the game - show game status
 */
$app->router->get("dice100/play", function () use ($app) {
    $title = "Play the game";

    $app->session->get("dice100");
    $app->page->add("dice100/play");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Play the game - roll dices
 */
$app->router->post("dice100/roll", function () use ($app) {
    $dice100 = $app->session->get("dice100");

    if (isset($_POST['roll'])) {
        if ($app->session->get("hasRolled") == false) {
            $app->session->set("currentScore", 0);
            $app->session->set("dices", "");
            $dice100->clearRolls();
            $dice100->clearCurrentScore();
        }
        if ($dice100->throw()) {
            $app->session->set("currentScore", 0);
            $dices = $dice100->getDices();
            $app->session->set("dices", $dices);
            $app->session->set("changePlayer", true);
            $app->session->set("hasRolled", false);
            $dice100->changePlayer();
            $app->session->set("currentPlayer", $dice100->getCurrentPlayer());
            if ($dice100->getCurrentPlayer() == "computer") {
                $app->session->set("computerPlaying", true);
            } else {
                $app->session->set("computerPlaying", false);
            }
        } else {
            $score = $dice100->getCurrentScore();
            $dices = $dice100->getDices();
            $app->session->set("currentScore", $score);
            $app->session->set("dices", $dices);
            $app->session->set("hasRolled", true);
        }

        unset($_POST['roll']);

        $app->page->add("dice100/play");

        return $app->response->redirect("dice100/play");
    }
});



/**
 * Save score
 */
$app->router->post("dice100/save", function () use ($app) {
    $dice100 = $app->session->get("dice100");

    if (isset($_POST['save'])) {
        if ($app->session->get("computerPlaying") == true) {
            if ($dice100->throw()) { // if the throw contains a one
                $app->session->set("currentScore", 0);
                $app->session->set("endOfTurn", true);
                $app->session->set("changePlayer", true);
                $dices = $dice100->getDices();
                $app->session->set("dices", $dices);
            } else {
                $score = $dice100->getCurrentScore();
                $dices = $dice100->getDices();
                $app->session->set("currentScore", $score);
                $app->session->set("dices", $dices);
            }
        }
        if ($app->session->get("hasRolled") == false) {
            $dice100->clearRolls();
            $dice100->clearCurrentScore();
        }

        $dice100->saveThrow($app->session->get("currentScore"));
        $hasWon = $dice100->hasWon();
        if ($hasWon) {
            $app->session->set("gameOver", $hasWon);
        }
        $totalScore = $dice100->getTotalScore();

        if ($app->session->get("computerPlaying") == true) {
            $app->session->set("computerTotal", $totalScore);
            $app->session->set("hasRolled", false);
            $app->session->set("computerPlaying", false);
        } else {
            $app->session->set("playerTotal", $totalScore);
            $app->session->set("computerPlaying", true);
        }
        $dice100->clearRolls();
        $dice100->clearCurrentScore();

        $dice100->changePlayer();
        $app->session->set("currentPlayer", $dice100->getCurrentPlayer());

        unset($_POST['save']);

        $app->page->add("dice100/play");

        return $app->response->redirect("dice100/play");
    }
});



/**
 * Reset game
 */
$app->router->post("dice100/reset", function () use ($app) {
    if (isset($_POST['reset'])) {
        $dice100 = new Magm19\Dice100\Dice100();
        $app->session->set("dice100", $dice100);
        $app->session->set("currentScore", 0);
        $app->session->set("dices", "");
        $app->session->set("currentPlayer", $dice100->getCurrentPlayer());
        $app->session->set("playerTotal", 0);
        $app->session->set("computerTotal", 0);
        $app->session->set("changePlayer", false);
        $app->session->set("computerPlaying", false);
        $app->session->set("gameOver", false);
        $app->session->set("hasRolled", false);
        return $app->response->redirect("dice100/play");
    }
});
