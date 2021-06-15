<?php
namespace Magm19\Dice100;

use Anax\Request\Request;

use \Magm10\Dice100\Player;

class Dice100
{
    /**
     * @var int $gameState   State of the game.
     * @var player $player   Object of player.
     * @var player $computer   Object of computer.
     */
    private $gameState;
    public $player;
    public $computer;
    private $currentPlayer;
    private $histogram;


    /**
     * Constructor to initiate the object and start the game
     */
    public function __construct()
    {
        $this->initGame();
        $this->player = new \Magm19\Dice100\Player();
        $this->computer = new \Magm19\Dice100\Player();
        $this->currentPlayer = $this->player;
    }



    /**
     * Initiates the game by setting gamestate to 1
     */
    private function initGame()
    {
        $this->gameState = 1;
    }


    /**
     * Changes gamestate to:
     * 0 = game over,
     * 1 = players turn,
     * 2 = computers turn
     */
    private function setGamestate($value)
    {
        $this->gameState = $value;
    }



    /**
     * Histogram stuff
     */
    public function getHistogram()
    {

        return $this->currentPlayer->getHistogram();
    }



    /**
     * returns gameState variable
     */
    private function getGameState()
    {
        return $this->gameState;
    }


    /**
     * Changes current player
     */
    public function changePlayer()
    {
        $gameState = $this->getGameState();
        if ($gameState == 1) {
            $this->currentPlayer = $this->computer;
            $this->setGamestate(2);
        } else {
            $this->currentPlayer = $this->player;
            $this->setGamestate(1);
        }
    }


    /**
     * returns current player
     */
    public function getCurrentPlayer()
    {
        $player = "player";
        if ($this->getGameState() == 2) {
            $player = "computer";
        }
        return $player;
    }



    /**
     * returns players current score
     */
    public function getCurrentScore()
    {
        return $this->currentPlayer->getCurrentHand();
    }



    /**
     * returns players current score
     */
    public function clearCurrentScore()
    {
        $this->currentPlayer->clearCurrentHand();
    }



    /**
     * returns players dices
     */
    public function getDices()
    {
        return $this->currentPlayer->getArray();
    }



    /**
     * returns players total score
     */
    public function getTotalScore()
    {
        return $this->currentPlayer->getScore();
    }



    /**
     * throws dices
     */
    public function clearRolls()
    {
        $player = $this->currentPlayer;
        $player->clearArray();
    }


    /**
     * throws dices
     */
    public function checkRolls()
    {
        $player = $this->currentPlayer;
        $player->checkArray();
    }


    /**
     * throws dices
     */
    public function throw()
    {
        if ($this->getGameState() != 0) {
            $player = $this->currentPlayer;
            $player->rollHand();
            return $player->checkArray();
        }
    }



    /**
     * saves throws
     */
    public function saveThrow($score)
    {
        $gameState = $this->getGameState();
        if ($gameState != 0) {
            $player = $this->currentPlayer;
            $player->setScore($score);
        }
    }



    /**
     * checks if current player has won
     */
    public function hasWon()
    {
        $player = $this->currentPlayer;
        if ($player->getScore() >= 100) {
            $winner = $this->getCurrentPlayer();
            $this->setGamestate(0);
            return $winner;
        }
    }
}
