<?php

namespace Markbench\Driver;

use Markbench\DriverInterface;
use Markbench\Exception\UnsupportedDriverException;
use Michelf\Markdown;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class PHPMarkdownDriver implements DriverInterface
{

    /**
     * @var Markdown
     */
    protected $phpMarkdown;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->phpMarkdown = new Markdown();
    }

    /**
     * {@inheritdoc}
     */
    public function run($markdown = '')
    {
        return $this->phpMarkdown->defaultTransform($markdown);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'michelf/php-markdown';
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
        if (!class_exists('Michelf\\Markdown')) {
            throw new UnsupportedDriverException();
        }
    }
}