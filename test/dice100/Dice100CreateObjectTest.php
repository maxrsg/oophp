<?php

namespace Magm19\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100
 */
class Dice100CreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice100 = new Dice100();
        $this->assertInstanceOf("\Magm19\Dice100\Dice100", $dice100);
    }



    /**
     * Construct object verify that the player object was created correctly
     */
    public function testPlayerObject()
    {
        $dice100 = new Dice100();
        $player = $dice100->getCurrentPlayer();
        $this->assertInstanceOf("\Magm19\Dice100\Player", $player);
    }



    /**
    * Construct object and verify that the hasWon method works as expected
    */
    public function testSaveThrow()
    {
        $dice100 = new Dice100();

        $dice100->saveThrow(25);
        $res = $dice100->getTotalScore();
        $exp = 25;
        $this->assertEquals($exp, $res);
    }



    /**
    * Construct object and verify that the hasWon method works as expected
    */
    public function testHasWon()
    {
        $dice100 = new Dice100();

        $res = $dice100->hasWon();
        $exp = "";
        $this->assertEquals($exp, $res);

        $dice100->saveThrow(100);
        $res = $dice100->hasWon();
        $exp = "player";
        $this->assertEquals($exp, $res);
    }



    /**
    * Construct object and verify that the changePlayer method works as expected
    */
    public function testChangePlayer()
    {
        $dice100 = new Dice100();

        $res = $dice100->getCurrentPlayer();
        $exp = "player";
        $this->assertEquals($exp, $res);

        $dice100->changePlayer();
        $res = $dice100->getCurrentPlayer();
        $exp = "computer";
        $this->assertEquals($exp, $res);
    }
}
