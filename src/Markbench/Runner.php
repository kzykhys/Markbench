<?php

namespace Markbench;

use KzykHys\Parallel\Parallel;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class Runner
{

    /**
     * @var DriverInterface[]
     */
    private $drivers = [];

    /**
     * @param DriverInterface $driver
     */
    public function addDriver(DriverInterface $driver)
    {
        $this->drivers[$driver->getName().$driver->getDialect()] = $driver;
    }

    /**
     * @return DriverInterface[]
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * @param string $markdown
     * @param int    $loopCount
     *
     * @return Result[]
     */
    public function run($markdown = '', $loopCount = 1000)
    {
        $tasks = array_map(function (DriverInterface $driver) use ($markdown, $loopCount) {
            $task = new Task($driver);
            $task->setContent($markdown)->setLoopCount($loopCount);

            return array($task, 'run');
        }, $this->drivers);

        $parallel = new Parallel();

        return $parallel->values($tasks);
    }

} 