<?php
/**
 * Init game and redirects to play.
 */
$app->router->get("guess/init", function () use ($app) {
    // init session for game
    $guess = new Magm19\Guess\Guess();
    $guess->random();
    $_SESSION['guess'] = $guess;
    return $app->response->redirect("guess/play");
});



/**
 * Play the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    $gameWon = false;
    $outOfGuesses = false;
    $guess = $_SESSION['guess'] ?? null;
    $guessMade = $_SESSION['guessMade'] ?? null;
    $cheat = $_SESSION['cheat'] ?? null;
    $exception = $_SESSION['exception'] ?? null;

    if ($guess) {
        if ($guess->tries() < 1) {
            $outOfGuesses = true;
        }

        if (strpos($guessMade, "is correct!") !== false) {
            $gameWon = true;
        }
    }

    $data = [
        "guess" => $guess ?? null,
        "cheat" => $cheat ?? null,
        "guessMade" => $guessMade ?? null,
        "exception" => $exception,
        "gameWon" => $gameWon,
        "outOfGuesses" => $outOfGuesses
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug"); //debug view
    
    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Play the game - make a guess
 */
$app->router->post("guess/guess", function () use ($app) {
    $guess = $_SESSION['guess'] ?? null;
    $guessMade = $_SESSION['guessMade'] ?? null;
    $exception = $_SESSION['exception'] ?? null;

    if (isset($_POST['input'])) {
        $input = (is_numeric($_POST['input']) ? (int)$_POST['input'] : 0);
        if (isset($_SESSION["guess"])) {
            try {
                $res = $guess->makeGuess($input);
                $_SESSION['guessMade'] = $res;
            } catch (Magm19\Guess\GuessException $ge) {
                $_SESSION['exception'] = $ge->getMessage();
            }
        }
        unset($_POST['input']);

        $data = [
            "guess" => $guess,
            "guessMade" => $guessMade,
            "exception" => $exception,
        ];

        $app->page->add("guess/play", $data);

        return $app->response->redirect("guess/play");
    }
});


/**
 * Play the game - make a guess
 */
$app->router->post("guess/reset", function () use ($app) {
    $guess = $_SESSION['guess'] ?? null;

    if (isset($_POST['reset'])) {
        $guess = new Magm19\Guess\Guess();
        $guess->random();
        $_SESSION["guess"] = $guess;
        unset($_POST['reset']);

        $data = [
            "guess" => $guess,
        ];

        $app->page->add("guess/play", $data);

        return $app->response->redirect("guess/play");
    }
});

/**
 * Play the game - make a guess
 */
$app->router->post("guess/cheat", function () use ($app) {
    $guess = $_SESSION['guess'] ?? null;
    $cheat = $_SESSION['cheat'] ?? null;

    if (isset($_POST['cheat'])) {
        $cheat = $guess->number();
        $_SESSION['cheat'] = $cheat;
        unset($_POST['cheat']);

        $data = [
            "guess" => $guess,
            "cheat" => $cheat,
        ];

        $app->page->add("guess/play", $data);

        return $app->response->redirect("guess/play");
    }
});
