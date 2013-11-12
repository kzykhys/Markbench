<?php

namespace Markbench\Driver;

use Michelf\MarkdownExtra;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class PHPMarkdownExtraDriver extends PHPMarkdownDriver
{

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->phpMarkdown = new MarkdownExtra();
    }

    /**
     * {@inheritdoc}
     */
    public function getDialect()
    {
        return 'extra';
    }

} 