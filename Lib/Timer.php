<?php

namespace COil\ToolsBundle\Lib;

class Timer
{
    /**
     * @var array Array of timers.
     */
    protected $timers = array();

    /**
     * Set the starting time for a given timer.
     *
     * @param string $name The name of the timer to use
     */
    public function start($name = 'default')
    {
        $this->timers[$name]['start'] = $this->getMicroTimeNow();
    }

    /**
     * Reset the timers array.
     */
    public function clear()
    {
        $this->timers = array();
    }

    /**
     * Returns all the timers.
     *
     * @return Array The array of all timers
     */
    public function all()
    {
        return $this->timers;
    }

    /**
     * Set the end time for a given timer.
     *
     * @param string $name The name of the timer to use
     */
    public function stop($name = 'default')
    {
        if (!isset($this->timers[$name]['start'])) {
            throw new \RuntimeException(__FUNCTION__. '(): stop() can\'t be called before start().');
        }

        $this->timers[$name]['stop'] = $this->getMicroTimeNow();
    }

    /**
     * Retrieve the elapsed time for a given timer.
     *
     * @param  string $name The name of the timer to use
     *
     * @return string
     */
    public function getTime($name = 'default')
    {
        if (!isset($this->timers[$name]['start'])) {
            throw new \RuntimeException(__FUNCTION__. '(): start the timer before getting the result.');
        }

        if (!isset($this->timers[$name]['stop'])) {
            $this->timers[$name]['stop'] = $this->getMicroTimeNow();
        }

        return $this->getElapsedTime(
            $this->timers[$name]['start'],
            $this->timers[$name]['stop']
        );
    }

    /**
     * Return microtime from a timestamp.
     *
     * @param  float  Timestamp to retrieve micro time
     *
     * @return float  Microtime of timestamp param
     */
    public function getMicroTime($time)
    {
        list($usec, $sec) = explode(' ', $time);

        return (float)$usec + (float)$sec;
    }

    /**
     * Alias.
     *
     * @return float
     */
    public function getMicroTimeNow()
    {
        return self::getMicroTime(microtime());
    }

    /**
     * Get the elapsed time between 2 time references.
     *
     * @param  float $timeStart    Start time
     * @param  float $timestop      stop time
     *
     * @return float               Numeric difference between the two times ref in format 0.0000 sec
     */
    public function getElapsedTime($timeStart, $timestop)
    {
        return round($timestop - $timeStart, 4);
    }
}