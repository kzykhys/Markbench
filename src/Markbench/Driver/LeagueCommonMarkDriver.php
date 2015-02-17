<?php

namespace Markbench\Driver;

use League\CommonMark\CommonMarkConverter;
use Markbench\DriverInterface;

/**
 * @author Colin O'Dell <colinodell@gmail.com>
 */
class LeagueCommonMarkDriver implements DriverInterface
{
    /**
     * @var CommonMarkConverter
     */
    private $conveter;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->converter = new CommonMarkConverter();
    }

    /**
     * {@inheritdoc}
     */
    public function run($markdown = '')
    {
        return $this->converter->convertToHtml($markdown);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'league/commonmark';
    }

    /**
     * {@inheritdoc}
     */
    public function getDialect()
    {
        return 'commonmark';
    }

    public function checkRequirements()
    {
        return class_exists('League\CommonMark\CommonMarkConverter');
    }
}

