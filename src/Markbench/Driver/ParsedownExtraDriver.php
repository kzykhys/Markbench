<?php

namespace Markbench\Driver;

use Markbench\DriverInterface;

/**
 * @author Carsten Brandt <mail@cebe.cc>
 */
class ParsedownExtraDriver implements DriverInterface
{

    /**
     * @var \ParsedownExtra
     */
    private $parsedown;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->parsedown = \ParsedownExtra::instance();
    }

    /**
     * {@inheritdoc}
     */
    public function run($markdown = '')
    {
        return $this->parsedown->text($markdown);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'erusev/parsedown-extra';
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
        return class_exists('ParsedownExtra');
    }

}
