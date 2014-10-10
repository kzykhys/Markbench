<?php

namespace Markbench\Driver;

use cebe\markdown\MarkdownExtra;
use Markbench\DriverInterface;

/**
 * @author Carsten Brandt <mail@cebe.cc>
 */
class CebeMarkdownExtraDriver implements DriverInterface
{

    /**
     * @var MarkdownExtra
     */
    private $markdown;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->markdown = new MarkdownExtra();
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
        return 'extra';
    }

    /**
     * {@inheritdoc}
     */
    public function checkRequirements()
    {
        return class_exists('cebe\markdown\MarkdownExtra');
    }

}
