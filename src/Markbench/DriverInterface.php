<?php

namespace Markbench;

interface DriverInterface
{

    public function initialize();

    public function run();

    public function getName();

    public function getVersion();

    public function checkRequirements();

}