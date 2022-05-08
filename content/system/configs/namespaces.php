<?php

$vendorDir = realpath(__DIR__ . '/../../../vendor');
$systemDir = realpath(__DIR__ . '/../');

return array(
    'Ecjia\System\AdminPanel' => $systemDir . '/admin-panel/src',
    'Ecjia\System\AdminUI'    => $systemDir . '/admin-ui/src',
    'Ecjia\System\Frameworks' => $systemDir . '/admin-frameworks/src',
);

//end