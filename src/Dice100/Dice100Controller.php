<?php

namespace Magm19\Dice100;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Dice100Controller implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * This is the index method action
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "Dice100";
    }



    /**
     * This is the debug method action
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Dice100 debug";
    }



    /**
     * This is the init method action.
     *
     * @return object
     */
    public function initAction() : object
    {
        $session = $this->app->session;
        $dice100 = new \Magm19\Dice100\Dice100();
        $session->set("dice100", $dice100);
        $session->set("currentScore", 0);
        $session->set("dices", "");
        $session->set("currentPlayer", $dice100->getCurrentPlayer());
        $session->set("playerTotal", 0);
        $session->set("computerTotal", 0);
        $session->set("changePlayer", false);
        $session->set("computerPlaying", false);
        $session->set("gameOver", false);
        $session->set("hasRolled", false);
        return $this->app->response->redirect("dice100/play");
    }



    /**
     * This is the play method action.
     *
     * @return object
     */
    public function playAction() : object
    {
        $title = "Play the game";

        $this->app->session->get("dice100");
        $this->app->page->add("dice100/play");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the roll method action.
     *
     * @return object
     */
    public function rollAction() : object
    {
        $request = $this->app->request;
        $session = $this->app->session;
        $dice100 = $session->get("dice100");
        $roll = $request->getPost("roll");

        if ($roll) {
            if ($session->get("hasRolled") == false) {
                $session->set("currentScore", 0);
                $session->set("dices", "");
                $dice100->clearRolls();
                $dice100->clearCurrentScore();
            }
            if ($dice100->throw()) {
                $session->set("currentScore", 0);
                $dices = $dice100->getDices();
                $session->set("dices", $dices);
                $session->set("changePlayer", true);
                $session->set("hasRolled", false);
                $dice100->changePlayer();
                $session->set("currentPlayer", $dice100->getCurrentPlayer());
                if ($dice100->getCurrentPlayer() == "computer") {
                    $session->set("computerPlaying", true);
                } else {
                    $session->set("computerPlaying", false);
                }
            } else {
                $score = $dice100->getCurrentScore();
                $dices = $dice100->getDices();
                $session->set("currentScore", $score);
                $session->set("dices", $dices);
                $session->set("hasRolled", true);
            }
            $request->setPost("histogram", $dice100->getHistogram());
            $request->setPost("roll", null);

            $this->app->page->add("dice100/play");

            return $this->app->response->redirect("dice100/play");
        }
    }



    /**
     * This is the save method action.
     *
     * @return object
     */
    public function saveAction() : object
    {
        $request = $this->app->request;
        $session = $this->app->session;
        $dice100 = $session->get("dice100");
        $save = $request->getPost("save");

        if ($save) {
            if ($session->get("computerPlaying") == true) {
                if ($dice100->throw()) { // if the throw contains a one
                    $session->set("currentScore", 0);
                    $session->set("endOfTurn", true);
                    $session->set("changePlayer", true);
                    $dices = $dice100->getDices();
                    $session->set("dices", $dices);
                } else {
                    $score = $dice100->getCurrentScore();
                    $dices = $dice100->getDices();
                    $session->set("currentScore", $score);
                    $session->set("dices", $dices);
                }
            }
            if ($session->get("hasRolled") == false) {
                $dice100->clearRolls();
                $dice100->clearCurrentScore();
            }

            $dice100->saveThrow($session->get("currentScore"));
            $hasWon = $dice100->hasWon();
            if ($hasWon) {
                $session->set("gameOver", $hasWon);
            }
            $totalScore = $dice100->getTotalScore();

            if ($session->get("computerPlaying") == true) {
                $session->set("computerTotal", $totalScore);
                $session->set("hasRolled", false);
                $session->set("computerPlaying", false);
            } else {
                $session->set("playerTotal", $totalScore);
                $session->set("computerPlaying", true);
            }
            $dice100->clearRolls();
            $dice100->clearCurrentScore();

            $dice100->changePlayer();
            $session->set("currentPlayer", $dice100->getCurrentPlayer());

            $request->setPost("save", null);

            $this->app->page->add("dice100/play");

            return $this->app->response->redirect("dice100/play");
        }
    }



    /**
     * This is the reset method action.
     *
     * @return object
     */
    public function resetAction() : object
    {
        $request = $this->app->request;
        $session = $this->app->session;
        $reset = $request->getPost("reset");

        if ($reset) {
            $dice100 = new \Magm19\Dice100\Dice100();
            $session->set("dice100", $dice100);
            $session->set("currentScore", 0);
            $session->set("dices", "");
            $session->set("currentPlayer", $dice100->getCurrentPlayer());
            $session->set("playerTotal", 0);
            $session->set("computerTotal", 0);
            $session->set("changePlayer", false);
            $session->set("computerPlaying", false);
            $session->set("gameOver", false);
            $session->set("hasRolled", false);
            $request->setPost("reset", null);

            return $this->app->response->redirect("dice100/play");
        }
    }
}
