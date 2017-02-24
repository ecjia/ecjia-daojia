<?php

// autoload.php

define('VENDOR_DIR', __DIR__);

require_once VENDOR_DIR . '/composer/autoload_real.php';

return ComposerAutoloaderInit::getLoader();
