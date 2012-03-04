<?php

/*
 * This file is part of the COil/ToolsBundle
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace COil\ToolsBundle\Tests\Lib;

use COil\ToolsBundle\Lib\Timer;

class TimerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers COil\ToolsBundle\Lib\Timer::all
     */
    public function testConstruct()
    {
        $timer = new Timer();
        $this->assertTrue(0 == count($timer->all()), '->::__construct: Empty init');
    }

    /**
     * @covers COil\ToolsBundle\Lib\Timer::start
     * @covers COil\ToolsBundle\Lib\Timer::stop
     * @covers COil\ToolsBundle\Lib\Timer::getTime
     */
    public function testStartWithoutArgument()
    {
        $timer = new Timer();
        $timer->start();
        $time = $timer->getTime();
        $this->assertTrue(is_float($time), '->stop(): Returns the elapsed time as a foat');
        $this->assertTrue(1 == count($timer->all()), '->start(): There is now one timer');

        $timer->start();
        $time = $timer->stop();
        $time = $timer->getTime();
        $this->assertTrue(is_float($time), '->stop(): Returns the elapsed time as a float');
        $this->assertTrue(1 == count($timer->all()), '->start(): The previous timer is overrided');
    }

    /**
     * @covers COil\ToolsBundle\Lib\Timer::all
     * @covers COil\ToolsBundle\Lib\Timer::start
     * @covers COil\ToolsBundle\Lib\Timer::stop
     * @covers COil\ToolsBundle\Lib\Timer::getTime
     */
    public function testAll()
    {
        $timer = new Timer();
        $this->assertTrue(0 == count($timer->all()), '->::all(): No timer at init');

        $timer->start();
        $time = $timer->stop();
        $this->assertTrue(1 == count($timer->all()), '->::all(): 1 timer after 1st stop call');

        $timer->start('myTimer');
        $time = $timer->getTime('myTimer');
        $this->assertTrue(2 == count($timer->all()), '->::all(): 2 timers after 2nd stop call with different timer name');

        $timer->start('myTimer2');
        $time = $timer->getTime('myTimer2');
        $this->assertTrue(3 == count($timer->all()), '->::all(): 3 timers after 2nd stop call with different timer name');
    }

    /**
     * @covers COil\ToolsBundle\Lib\Timer::clear
     * @covers COil\ToolsBundle\Lib\Timer::start
     * @covers COil\ToolsBundle\Lib\Timer::getTime
     * @covers COil\ToolsBundle\Lib\Timer::all
     */
    public function testClear()
    {
        $timer = new Timer();
        $timer->clear();
        $this->assertTrue(0 == count($timer->all()), '->::clear(): At init nothing to clear');

        $timer->start('myTimer');
        $time = $timer->getTime('myTimer');
        $timer->start('myTimer2');
        $time = $timer->getTime('myTimer2');
        $timer->start('myTimer3');
        $timer->clear();
        $timers = $timer->all();
        $this->assertTrue(empty($timers), '->::clear(): After clear() no timer is available');
    }

    /**
     * Get time raise an exception if the timer was not started.
     *
     * @covers COil\ToolsBundle\Lib\Timer::getTime
     * @expectedException \RuntimeException
     */
    public function testGetTimeException()

    {
        $timer = new Timer();
        $time = $timer->getTime('myTimer');
    }

    /**
     * stop raise an exception if the timer was not started.
     *
     * @covers COil\ToolsBundle\Lib\Timer::stop
     * @expectedException \RuntimeException
     */
    public function testStopException()

    {
        $timer = new Timer();
        $time = $timer->stop('myTimer');
    }
}
