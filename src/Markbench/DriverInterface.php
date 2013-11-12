<?php

namespace Markbench;

use Markbench\Exception\UnsupportedDriverException;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
interface DriverInterface
{

    /**
     * Initialize a parser
     *
     * @return void
     */
    public function initialize();

    /**
     * Transform markdown into HTML
     *
     * @param string $markdown
     *
     * @return string
     */
    public function run($markdown = '');

    /**
     * Returns the package name of composer
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the name of dialect
     *
     * @return mixed
     */
    public function getDialect();

    /**
     * @throws UnsupportedDriverException
     * @return void
     */
    public function checkRequirements();

}