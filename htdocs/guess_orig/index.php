<?php
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");

session_name("magm19");
session_start();
$gameWon = false;
$outOfGuesses = false;
$guess = $_SESSION['guess'] ?? null;
$guessMade = $_SESSION['guessMade'] ?? null;
$cheat = $_SESSION['cheat'] ?? null;
$exception = $_SESSION['exception'] ?? null;

if (!isset($_SESSION["guess"])) {
    $guess = new Guess();
    $guess->random();
    $_SESSION['guess'] = $guess;
} else {
    if ($guess->tries() < 1) {
        $outOfGuesses = true;
    }

    if (strpos($guessMade, "is correct!") !== false) {
        $gameWon = true;
    }
}

    require __DIR__ . "/view/form.php";
