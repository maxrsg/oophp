<?php

namespace Magm19\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice
 */
class DiceCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Magm19\Dice100\Dice", $dice);
    }



    /**
    * Construct object and verify that the getValue method works as expected
     */
    public function testGetValue()
    {
        $dice = new Dice();

        $res = $dice->getValue();
        $exp = (1 <= $res) && ($res <= 6);
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the roll method works as expected
     */
    public function testRoll()
    {
        $dice = new Dice();

        $dice->roll();
        $res = $dice->getValue();
        $exp = (1 <= $res) && ($res <= 6);
        $this->assertEquals($exp, $res);
    }
}
