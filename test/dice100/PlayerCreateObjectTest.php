<?php

namespace Magm19\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player
 */
class PlayerCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $player = new Player();
        $this->assertInstanceOf("\Magm19\Dice100\Player", $player);
    }



    /**
    * Construct object and verify that the rollHand method works as expected
     */
    public function testRollHand()
    {
        $player = new Player();
        $this->assertInstanceOf("\Magm19\Dice100\Player", $player);

        $player->rollHand();
        $res = $player->getCurrentHand();
        $exp = (2 <= $res) && ($res <= 12);
        $this->assertEquals($exp, $res);
    }


    /**
    * Construct object and verify that the checkArray method works as expected
     */
    public function testCheckArray()
    {
        $player = new Player();
        $this->assertInstanceOf("\Magm19\Dice100\Player", $player);

        $check = $player->getArray();
        $res = $player->checkArray();
        if (strpos($check, '1') !== false) {
            $exp = true;
        } else {
            $exp = false;
        }
        $this->assertEquals($exp, $res);
    }



    /**
    * Construct object and verify that the checkArray method works as expected
     */
    public function testClear()
    {
        $player = new Player();
        $this->assertInstanceOf("\Magm19\Dice100\Player", $player);

        $player->rollHand();
        $player->clearArray();
        $res = $player->checkArray();
        $exp = array();
        $this->assertEquals($exp, $res);
    }



    /**
    * Construct object and verify that the setScore method works as expected
     */
    public function testSetScore()
    {
        $player = new Player();
        $this->assertInstanceOf("\Magm19\Dice100\Player", $player);

        $player->setScore(10);

        $res = $player->getScore();
        $exp = 10;
        $this->assertEquals($exp, $res);

        $res = $player->getCurrentHand();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }
}
