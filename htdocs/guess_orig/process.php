<?php
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");

session_name("magm19");
session_start();

if (isset($_SESSION['guess'])) {
    $guess = $_SESSION["guess"];
}

if (isset($_POST['reset'])) {
    $guess = new Guess(1, 6);
    $guess->random();
    $_SESSION["guess"] = $guess;
    unset($_POST['reset']);
} elseif (isset($_POST['cheat'])) {
    $cheat = $guess->number();
    $_SESSION['cheat'] = $cheat;
    unset($_POST['cheat']);
} elseif (isset($_POST['input'])) {
    $input = (is_numeric($_POST['input']) ? (int)$_POST['input'] : 0);
    if (isset($_SESSION["guess"])) {
        try {
            $res = $guess->makeGuess($input);
            $_SESSION['guessMade'] = $res;
        } catch (\Throwable $th) {
            $_SESSION['exception'] = $th;
        }
    }
    unset($_POST['input']);
}

// Redirect to a result page.
$url = "index.php";
header("Location: $url");
