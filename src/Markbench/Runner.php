<?php

namespace Markbench;

use KzykHys\Parallel\Parallel;

class Runner
{

    /**
     * @var DriverInterface[]
     */
    private $drivers;

    /**
     * @param DriverInterface $driver
     */
    public function addDriver(DriverInterface $driver)
    {
        $this->drivers[] = $driver;
    }

    public function run($markdown = '', $loopCount = 1000)
    {
        $tasks = array_map(function (DriverInterface $driver) use ($markdown) {
            $task = new Task($driver);
            $task->setContent($markdown);

            return array($task, 'run');
        }, $this->drivers);

        $parallel = new Parallel();
        $result = $parallel->values($tasks);

        var_dump($result);
    }

} 