<?php

namespace Markbench\Driver;

use Markbench\DriverInterface;
use Markbench\Exception\UnsupportedDriverException;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class ParsedownDriver implements DriverInterface
{

    /**
     * @var \Parsedown
     */
    private $parsedown;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->parsedown = \Parsedown::instance();
    }

    /**
     * {@inheritdoc}
     */
    public function run($markdown = '')
    {
        return $this->parsedown->parse($markdown);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'erusev/parsedown';
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
        return class_exists('Parsedown');
    }

}
