<?php

/**
 * Set PHP_VERSION_ID on php5.2.7-.
 * @see https://www.php.net/manual/en/function.version-compare.php
 */
if (!\defined('PHP_VERSION_ID')) {
    $version = \explode('.', \PHP_VERSION);
    \define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    unset($version);
}
