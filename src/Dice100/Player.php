<?php

namespace Magm19\Dice100;

use \Magm10\Dice100\Dice;

class Player
{
    private $score;
    private $currentHand;
    private $dice1;
    private $dice2;
    private $diceArray = array();
    private $histogram;



    /**
     * Constructor to create a Player.
    */
    public function __construct()
    {
        // $this->dice1 = new \Magm19\Dice100\Dice();
        // $this->dice2 = new \Magm19\Dice100\Dice();
        $this->dice1 = new \Magm19\Dice100\DiceHistogram();
        $this->dice2 = new \Magm19\Dice100\DiceHistogram();
        $this->histogram = new Histogram;
    }



    /**
     * Roll the dices and sets $currentHand.
     *
     */
    public function rollHand()
    {
        $this->diceArray = array();
        $this->dice1->roll();
        $this->dice2->roll();
        array_push($this->diceArray, $this->dice1->getValue(), $this->dice2->getValue());
        $this->currentHand += $this->dice1->getValue() + $this->dice2->getValue();
        $this->histogram->injectData($this->dice1);
    }



    /**
     * returns diceArray
     */
    public function getArray()
    {
        $lastTwo = array_slice($this->diceArray, -2);
        return implode(", ", $lastTwo);
    }



    /**
     * returns histogram
     */
    public function getHistogram()
    {
        return $this->histogram;
    }



    /**
     * checks if there are any ones in diceArray
     */
    public function checkArray()
    {
        $hasOne = false;
        $dices = $this->getArray();
        if (strpos($dices, '1') !== false) {
            $hasOne = true;
        }
        return $hasOne;
    }


    /**
     * clears array from rolls
     */
    public function clearArray()
    {
        $this->diceArray = array();
    }



    /**
     * Get the players score
     */
    public function setScore($val)
    {
        $this->score += $val;
        $this->diceArray = array();
        $this->currentHand = 0;
    }



    /**
     * Get the players score
     * @return int as value of score
     */
    public function getScore()
    {
        return $this->score;
    }



    /**
     * Get the value of the dice.
     *
     * @return int as the value of the current hand.
     */
    public function getCurrentHand()
    {
        return $this->currentHand;
    }



    /**
     * Get the value of the dice.
     *
     * @return int as the value of the current hand.
     */
    public function clearCurrentHand()
    {
        $this->currentHand = 0;
    }
}
