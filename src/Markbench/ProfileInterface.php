<?php

namespace Markbench;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
interface ProfileInterface
{

    /**
     * Returns the name of this profile
     *
     * @return mixed
     */
    public function getName();

    /**
     * Describe this profile
     *
     * @return string
     */
    public function getDescription();

    /**
     * Returns markdown content to test
     *
     * @return string
     */
    public function getContent();

    /**
     * @return mixed
     */
    public function getLoopCount();

} 