<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

<<<<<<< HEAD
=======
if (PHP_SAPI !== 'cli') {
    die("Example scripts are meant to be executed locally via CLI.");
}

>>>>>>> v2-test
require __DIR__.'/../autoload.php';

function redis_version($info)
{
    if (isset($info['Server']['redis_version'])) {
        return $info['Server']['redis_version'];
    } elseif (isset($info['redis_version'])) {
        return $info['redis_version'];
    } else {
        return 'unknown version';
    }
}

$single_server = array(
<<<<<<< HEAD
    'host'     => '127.0.0.1',
    'port'     => 6379,
=======
    'host' => '127.0.0.1',
    'port' => 6379,
>>>>>>> v2-test
    'database' => 15,
);

$multiple_servers = array(
    array(
<<<<<<< HEAD
       'host'     => '127.0.0.1',
       'port'     => 6379,
       'database' => 15,
       'alias'    => 'first',
    ),
    array(
       'host'     => '127.0.0.1',
       'port'     => 6380,
       'database' => 15,
       'alias'    => 'second',
=======
       'host' => '127.0.0.1',
       'port' => 6379,
       'database' => 15,
       'alias' => 'first',
    ),
    array(
       'host' => '127.0.0.1',
       'port' => 6380,
       'database' => 15,
       'alias' => 'second',
>>>>>>> v2-test
    ),
);
