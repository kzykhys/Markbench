<?php

namespace Markbench;

use Symfony\Component\Stopwatch\Stopwatch;

class Task
{

    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var string
     */
    private $content;

    /**
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param string $content
     *
     * @return Task
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function run()
    {
        $stopwatch = new Stopwatch();

        $this->driver->initialize();

        return array('foo');
    }

} 