<?php

namespace Markbench;

use Symfony\Component\Stopwatch\Stopwatch;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class Task
{

    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var string
     */
    private $content = '';

    /**
     * @var int
     */
    private $loopCount = 1000;

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

    /**
     * @param int $loopCount
     *
     * @return $this
     */
    public function setLoopCount($loopCount)
    {
        $this->loopCount = $loopCount;

        return $this;
    }

    /**
     * @return Result
     */
    public function run()
    {
        $stopwatch = new Stopwatch();
        $result    = '';

        $stopwatch->start('parsing');
        $this->driver->initialize();
        $stopwatch->lap('parsing');

        for ($i = 0; $i < $this->loopCount; $i++) {
            $result = $this->driver->run($this->content);
        }

        $event = $stopwatch->stop('parsing');

        return new Result($this->driver->getName(), $this->driver->getDialect(), $event, $result, memory_get_peak_usage(true));
    }

} 