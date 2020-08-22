<?php

namespace Magm19\Dice100;

class Dice
{
    private $value;



    /**
     * Get the value of the dice.
     *
     * @return int as the value of the dice.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Roll the dice and sets $value.
     *
     */
    public function roll()
    {
        $roll = rand(1, 6);
        $this->value = $roll;
    }



    /**
     * Constructor to create a Dice.
    */
    public function __construct()
    {
        $this->roll();
    }
}
