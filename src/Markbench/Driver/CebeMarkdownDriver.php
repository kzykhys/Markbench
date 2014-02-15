<?php

namespace Markbench\Driver;

use cebe\markdown\Markdown;
use Markbench\DriverInterface;

/**
 * @author Carsten Brandt <mail@cebe.cc>
 */
class CebeMarkdownDriver implements DriverInterface
{

    /**
     * @var Markdown
     */
    private $markdown;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->markdown = new Markdown();
    }

    /**
     * {@inheritdoc}
     */
    public function run($markdown = '')
    {
        return $this->markdown->parse($markdown);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cebe/markdown';
    }

    /**
     * {@inheritdoc}
     */
    public function getDialect()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function checkRequirements()
    {
        return class_exists('cebe\markdown\Markdown');
    }

}
