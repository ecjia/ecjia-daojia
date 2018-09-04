<?php

return array(
    'dsn' => env('SENTRY_DSN'),

    // capture release as git sha
    // trim(exec('git log --pretty="%h" -n1 HEAD'))
    'release' => Royalcms\Component\Foundation\Royalcms::VERSION,

    // Capture bindings on SQL queries
    'breadcrumbs.sql_bindings' => true,

    // Capture default user context
    'user_context' => false,
);
