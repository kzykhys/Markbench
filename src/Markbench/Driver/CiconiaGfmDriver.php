<?php

namespace Markbench\Driver;

use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class CiconiaGfmDriver extends CiconiaDriver
{

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->ciconia = new Ciconia();
        $this->ciconia->addExtensions([
            new Gfm\FencedCodeBlockExtension(),
            new Gfm\InlineStyleExtension(),
            new Gfm\TableExtension(),
            new Gfm\TaskListExtension(),
            new Gfm\WhiteSpaceExtension()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getDialect()
    {
        return 'gfm';
    }

} 