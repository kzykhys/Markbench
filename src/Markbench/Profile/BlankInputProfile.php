<?php

namespace Markbench\Profile;

use Markbench\ProfileInterface;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class BlankInputProfile implements ProfileInterface
{

    /**
     * Returns the name of this profile
     *
     * @return mixed
     */
    public function getName()
    {
        return 'blank';
    }

    /**
     * Describe this profile
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Blank input "" / 1000 times';
    }

    /**
     * Returns markdown content to test
     *
     * @return string
     */
    public function getContent()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getLoopCount()
    {
        return 1000;
    }

}