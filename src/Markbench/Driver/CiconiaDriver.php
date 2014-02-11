<?php

namespace Markbench\Driver;

use Ciconia\Ciconia;
use Markbench\DriverInterface;
use Markbench\Exception\UnsupportedDriverException;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class CiconiaDriver implements DriverInterface
{

    /**
     * @var Ciconia
     */
    protected $ciconia;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->ciconia = new Ciconia();
    }

    /**
     * {@inheritdoc}
     */
    public function run($markdown = '')
    {
        return $this->ciconia->render($markdown);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kzykhys/ciconia';
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
        return class_exists('Ciconia\\Ciconia');
    }

}
