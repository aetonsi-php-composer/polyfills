<?php

/**
 * Set PHP_VERSION_ID on php5.2.7-.
 * @see https://www.php.net/manual/en/function.phpversion.php
 */
if (!\defined('PHP_VERSION_ID')) {
    \call_user_func(function () {
        $version = \explode('.', \PHP_VERSION);
        \define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        if (\PHP_VERSION_ID < 50207) {
            \define('PHP_MAJOR_VERSION',   $version[0]);
            \define('PHP_MINOR_VERSION',   $version[1]);
            \define('PHP_RELEASE_VERSION', $version[2]);
        }
    });
}
