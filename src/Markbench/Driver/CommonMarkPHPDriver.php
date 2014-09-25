<?php

namespace Markbench\Driver;

use ColinODell\CommonMark\CommonMarkConverter;
use Markbench\DriverInterface;

/**
 * @author Colin O'Dell <colinodell@gmail.com>
 */
class CommonMarkPHPDriver implements DriverInterface
{

    /**
     * @var CommonMarkConverter
     */
    private $converter;

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
        return 'colinodell/commonmark-php';
    }

    /**
     * {@inheritdoc}
     */
    public function getDialect()
    {
        return 'commonmark';
    }

    /**
     * {@inheritdoc}
     */
    public function checkRequirements()
    {
        return class_exists('ColinODell\CommonMark\CommonMarkConverter');
    }
}
