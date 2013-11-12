<?php

namespace Markbench;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class Renderer
{

    /**
     * @var Result[]
     */
    private $results;

    /**
     * @param array Result[]
     */
    public function __construct($results = [])
    {
        $this->results = $results;
    }

    public function render(OutputInterface $output)
    {

    }

} 