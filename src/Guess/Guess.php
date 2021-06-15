<?php

namespace Magm19\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    private $number;
    private $tries;


    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->number = $number;
        $this->tries = $tries;
    }


    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function random()
    {
        $randNum = rand(1, 100);
        $this->number = $randNum;
    }


    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function tries()
    {
        return $this->tries;
    }


    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number()
    {
        return $this->number;
    }


    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess($number)
    {
        $res = "";
        if ($this->tries > 0) {
            $this->tries--;

            if (!is_int($number)) {
                throw new GuessException("Number must be an int");
            } elseif ($number < 0) {
                throw new GuessException("Number must be positive");
            } elseif ($number > 100) {
                throw new GuessException("Number cant be higher than 100");
            } elseif ($number == $this->number) {
                $res = strval($number) . " is correct!";
            } elseif ($number > $this->number) {
                $res = strval($number) . " is too high!";
            } elseif ($number < $this->number) {
                $res = strval($number) . " is too low!";
            } else {
                $res = "idfk";
            }
        } else {
            $res = "OUT OF TRIES";
        }
        return $res;
    }
}
