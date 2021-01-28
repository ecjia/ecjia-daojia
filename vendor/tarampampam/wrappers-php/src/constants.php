<?php

declare(strict_types=1);

/**
 * Convert empty arrays into empty objects (`[]` => `{}`).
 *
 * Available only for `\Tarampampam\Wrappers\Json::encode()` method (can be passed as 2nd parameter).
 *
 * @since 1.5.0
 */
if (! \defined('JSON_EMPTY_ARRAYS_TO_OBJECTS')) {
    \define('JSON_EMPTY_ARRAYS_TO_OBJECTS', 8388608);
}

/*
 * Use 2 (instead 4) whitespaces in returned data to format it.
 *
 * Available only for `\Tarampampam\Wrappers\Json::encode()` method (can be passed as 2nd parameter).
 *
 * @since 1.5.0
 */
if (! \defined('JSON_PRETTY_PRINT_2_SPACES')) {
    \define('JSON_PRETTY_PRINT_2_SPACES', 16777216);
}
