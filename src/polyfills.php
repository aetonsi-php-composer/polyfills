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


if (!function_exists('intdiv')) {
    /**
     * Polyfill for \intdiv().
     *
     * @see https://www.php.net/manual/en/function.intdiv.php#117626
     */
    function intdiv($a, $b)
    {
        return ($a - $a % $b) / $b;
    }
}


if (!function_exists('random_int')) {
    /**
     * Polyfill for \random_int().
     *
     * @see https://www.php.net/manual/en/function.random-int.php#119670
     */
    function random_int($min, $max)
    {
        if (!function_exists('mcrypt_create_iv')) {
            trigger_error(
                'mcrypt must be loaded for random_int to work',
                E_USER_WARNING
            );
            return null;
        }

        if (!is_int($min) || !is_int($max)) {
            trigger_error('$min and $max must be integer values', E_USER_NOTICE);
            $min = (int)$min;
            $max = (int)$max;
        }

        if ($min > $max) {
            trigger_error('$max can\'t be lesser than $min', E_USER_WARNING);
            return null;
        }

        $range = $counter = $max - $min;
        $bits = 1;

        while ($counter >>= 1) {
            ++$bits;
        }

        $bytes = (int)max(ceil($bits / 8), 1);
        $bitmask = pow(2, $bits) - 1;

        if ($bitmask >= PHP_INT_MAX) {
            $bitmask = PHP_INT_MAX;
        }

        do {
            $result = hexdec(
                bin2hex(
                    mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM)
                )
            ) & $bitmask;
        } while ($result > $range);

        return $result + $min;
    }
}
