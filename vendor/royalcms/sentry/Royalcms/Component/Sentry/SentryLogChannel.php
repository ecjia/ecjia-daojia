<?php

namespace Royalcms\Component\Sentry;

use Royalcms\Component\Log\LogManager;
use Monolog\Handler\RavenHandler;
use Monolog\Logger;

class SentryLogChannel extends LogManager
{
    /**
     * @param array $config
     *
     * @return Logger
     */
    public function __invoke(array $config)
    {
        $handler = new RavenHandler(
            $this->royalcms->make('sentry'),
            isset($config['level']) ? $config['level'] : null,
            isset($config['bubble']) ? $config['bubble'] : true
        );

        return new Logger($this->parseChannel($config), [$this->prepareHandler($handler, $config)]);
    }
}
