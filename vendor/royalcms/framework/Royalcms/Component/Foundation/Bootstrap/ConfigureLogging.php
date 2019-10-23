<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Log\Writer;
use Monolog\Logger as Monolog;
use Royalcms\Component\Contracts\Foundation\Royalcms;

class ConfigureLogging
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        $log = $this->registerLogger($royalcms);

        // If a custom Monolog configurator has been registered for the application
        // we will call that, passing Monolog along. Otherwise, we will grab the
        // the configurations for the log system and use it for configuration.
        if ($royalcms->hasMonologConfigurator()) {
            call_user_func(
                $royalcms->getMonologConfigurator(), $log->getMonolog()
            );
        } else {
            $this->configureHandlers($royalcms, $log);
        }
    }

    /**
     * Register the logger instance in the container.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return \Royalcms\Component\Log\Writer
     */
    protected function registerLogger(Royalcms $royalcms)
    {
        $royalcms->instance('log', $log = new Writer(
            new Monolog($royalcms->environment()), $royalcms['events'])
        );

        return $log;
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Log\Writer  $log
     * @return void
     */
    protected function configureHandlers(Royalcms $royalcms, Writer $log)
    {
        $method = 'configure'.ucfirst($royalcms['config']['system.log']).'Handler';

        $this->{$method}($royalcms, $log);
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Log\Writer  $log
     * @return void
     */
    protected function configureSingleHandler(Royalcms $royalcms, Writer $log)
    {
        $log->useFiles($royalcms->storagePath().'/logs/royalcms.log');
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Log\Writer  $log
     * @return void
     */
    protected function configureDailyHandler(Royalcms $royalcms, Writer $log)
    {
        $log->useDailyFiles(
            $royalcms->storagePath().'/logs/royalcms.log',
            $royalcms->make('config')->get('system.log_max_files', 5)
        );
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Log\Writer  $log
     * @return void
     */
    protected function configureSyslogHandler(Royalcms $app, Writer $log)
    {
        $log->useSyslog('royalcms');
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Log\Writer  $log
     * @return void
     */
    protected function configureErrorlogHandler(Royalcms $royalcms, Writer $log)
    {
        $log->useErrorLog();
    }
}
