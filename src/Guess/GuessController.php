<?php

namespace Magm19\Guess;

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
class GuessController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    // }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "Guess I guess";
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug I guess";
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        $guess = new \Magm19\Guess\Guess();
        $guess->random();
        $this->app->session->set("guess", $guess);
        return $this->app->response->redirect("guess1/play");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playAction() : object
    {
        $title = "Play the game";

        $gameWon = false;
        $outOfGuesses = false;
        $guess =  $this->app->session->get("guess");
        $guessMade =  $this->app->session->get("guessMade");
        $cheat =  $this->app->session->get("cheat");
        $exception =  $this->app->session->get("exception");

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

        $this->app->page->add("guess1/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function guessAction()
    {
        $request = $this->app->request;
        $session = $this->app->session;
        $guess = $session->get("guess");
        $guessMade = $session->get("guessMade");
        $exception = $session->get("exception");
        $guessed = $request->getPost("input");

        if ($guessed) {
            $input = (is_numeric($_POST['input']) ? (int)$_POST['input'] : 0);
            if (isset($guess)) {
                try {
                    $res = $guess->makeGuess($input);
                    $session->set("guessMade", $res);
                } catch (\Magm19\Guess\GuessException $ge) {
                    $session->set("exception", $ge->getMessage());
                }
            }
            unset($_POST['input']);

            $data = [
                "guess" => $guess,
                "guessMade" => $guessMade,
                "exception" => $exception,
            ];

            $this->app->page->add("guess1/play", $data);

            return $this->app->response->redirect("guess1/play");
        }
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function cheatAction() : object
    {
        $request = $this->app->request;
        $session = $this->app->session;
        $guess = $session->get("guess");
        $cheat = $session->get("cheat");
        $cheated = $request->getPost("cheat");

        if ($cheated) {
            $cheat = $guess->number();
            $session->set("cheat", $cheat);
            $request->setPost("cheat", null);

            $data = [
                "guess" => $guess,
                "cheat" => $cheat,
            ];

            $this->app->page->add("guess1/play", $data);

            return $this->app->response->redirect("guess1/play");
        }
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function resetAction() : object
    {
        $request = $this->app->request;
        $session = $this->app->session;
        $guess = $session->get("guess");
        $reset = $request->getPost("reset");
        if ($reset) {
            $guess = new \Magm19\Guess\Guess();
            $guess->random();
            $session->set("guess", $guess);
            $request->setPost("reset", null);

            $data = [
                "guess" => $guess,
            ];

            $this->app->page->add("guess1/play", $data);

            return $this->app->response->redirect("guess1/play");
        }
    }
}
