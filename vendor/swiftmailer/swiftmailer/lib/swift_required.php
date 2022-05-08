<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

<<<<<<< HEAD
/*
 * Autoloader and dependency injection initialization for Swift Mailer.
 */

if (class_exists('Swift', false)) {
    return;
}

// Load Swift utility class
require __DIR__.'/classes/Swift.php';

if (!function_exists('_swiftmailer_init')) {
    function _swiftmailer_init()
    {
        require __DIR__.'/swift_init.php';
    }
}

// Start the autoloader and lazy-load the init script to set up dependency injection
Swift::registerAutoload('_swiftmailer_init');
=======
require __DIR__.'/classes/Swift.php';

Swift::registerAutoload(function () {
    // Load in dependency maps
    require __DIR__.'/dependency_maps/cache_deps.php';
    require __DIR__.'/dependency_maps/mime_deps.php';
    require __DIR__.'/dependency_maps/message_deps.php';
    require __DIR__.'/dependency_maps/transport_deps.php';

    // Load in global library preferences
    require __DIR__.'/preferences.php';
});
>>>>>>> v2-test
