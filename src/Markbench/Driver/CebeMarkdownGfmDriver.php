<?php

namespace Markbench\Driver;

use cebe\markdown\GithubMarkdown;
use Markbench\DriverInterface;

/**
 * @author Carsten Brandt <mail@cebe.cc>
 */
class CebeMarkdownGfmDriver implements DriverInterface
{

    /**
     * @var GithubMarkdown
     */
    private $markdown;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->markdown = new GithubMarkdown();
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
        return 'gfm';
    }

    /**
     * {@inheritdoc}
     */
    public function checkRequirements()
    {
        return class_exists('cebe\markdown\GithubMarkdown');
    }

}
