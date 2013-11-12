<?php

namespace Markbench;

use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class Result implements \Serializable
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var
     */
    private $output;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var int
     */
    private $memory;

    /**
     * @var int
     */
    private $peakMemory;
    /**
     * @var string
     */
    private $dialect;

    /**
     * @param                $name
     * @param                $dialect
     * @param StopwatchEvent $event
     * @param                $output
     * @param                $peakMemory
     */
    public function __construct($name, $dialect, StopwatchEvent $event, $output, $peakMemory)
    {
        $this->name       = $name;
        $this->output     = $output;
        $this->duration   = $event->getDuration();
        $this->memory     = $event->getMemory();
        $this->peakMemory = $peakMemory;
        $this->dialect    = $dialect;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDialect()
    {
        return $this->dialect;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @return int
     */
    public function getPeakMemory()
    {
        return $this->peakMemory;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * String representation of object
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize([
            $this->name,
            $this->dialect,
            $this->output,
            $this->duration,
            $this->memory,
            $this->peakMemory
        ]);
    }

    /**
     * Constructs the object
     *
     * @param string $serialized The string representation of the object.
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        list(
            $this->name,
            $this->dialect,
            $this->output,
            $this->duration,
            $this->memory,
            $this->peakMemory
        ) = unserialize($serialized);
    }

}
