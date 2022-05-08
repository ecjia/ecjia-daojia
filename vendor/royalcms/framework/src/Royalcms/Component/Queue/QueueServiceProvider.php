<?php

namespace Royalcms\Component\Queue;


class QueueServiceProvider extends \Illuminate\Queue\QueueServiceProvider
{
    /**
     * The application instance.
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms|\Illuminate\Contracts\Foundation\Application $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->loadAlias();

        parent::register();
    }

    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();

        foreach (self::aliases() as $class => $alias) {
            $loader->alias($class, $alias);
        }
    }

    /**
     * Load the alias = One less install step for the user
     */
    public static function aliases()
    {

        return [
            'Royalcms\Component\Queue\BeanstalkdQueue'                       => 'Illuminate\Queue\BeanstalkdQueue',
            'Royalcms\Component\Queue\CallQueuedHandler'                     => 'Illuminate\Queue\CallQueuedHandler',
            'Royalcms\Component\Queue\Capsule\Manager'                       => 'Illuminate\Queue\Capsule\Manager',
            'Royalcms\Component\Queue\Connectors\BeanstalkdConnector'        => 'Illuminate\Queue\Connectors\BeanstalkdConnector',
            'Royalcms\Component\Queue\Connectors\ConnectorInterface'         => 'Illuminate\Queue\Connectors\ConnectorInterface',
            'Royalcms\Component\Queue\Connectors\DatabaseConnector'          => 'Illuminate\Queue\Connectors\DatabaseConnector',
            'Royalcms\Component\Queue\Connectors\IronConnector'              => 'Illuminate\Queue\Connectors\IronConnector',
            'Royalcms\Component\Queue\Connectors\NullConnector'              => 'Illuminate\Queue\Connectors\NullConnector',
            'Royalcms\Component\Queue\Connectors\RedisConnector'             => 'Illuminate\Queue\Connectors\RedisConnector',
            'Royalcms\Component\Queue\Connectors\SqsConnector'               => 'Illuminate\Queue\Connectors\SqsConnector',
            'Royalcms\Component\Queue\Connectors\SyncConnector'              => 'Illuminate\Queue\Connectors\SyncConnector',
            'Royalcms\Component\Queue\Console\FailedTableCommand'            => 'Illuminate\Queue\Console\FailedTableCommand',
            'Royalcms\Component\Queue\Console\FlushFailedCommand'            => 'Illuminate\Queue\Console\FlushFailedCommand',
            'Royalcms\Component\Queue\Console\ForgetFailedCommand'           => 'Illuminate\Queue\Console\ForgetFailedCommand',
            'Royalcms\Component\Queue\Console\ListFailedCommand'             => 'Illuminate\Queue\Console\ListFailedCommand',
            'Royalcms\Component\Queue\Console\ListenCommand'                 => 'Illuminate\Queue\Console\ListenCommand',
            'Royalcms\Component\Queue\Console\RestartCommand'                => 'Illuminate\Queue\Console\RestartCommand',
            'Royalcms\Component\Queue\Console\RetryCommand'                  => 'Illuminate\Queue\Console\RetryCommand',
            'Royalcms\Component\Queue\Console\SubscribeCommand'              => 'Illuminate\Queue\Console\SubscribeCommand',
            'Royalcms\Component\Queue\Console\TableCommand'                  => 'Illuminate\Queue\Console\TableCommand',
            'Royalcms\Component\Queue\Console\WorkCommand'                   => 'Illuminate\Queue\Console\WorkCommand',
            'Royalcms\Component\Queue\DatabaseQueue'                         => 'Illuminate\Queue\DatabaseQueue',
            'Royalcms\Component\Queue\Failed\DatabaseFailedJobProvider'      => 'Illuminate\Queue\Failed\DatabaseFailedJobProvider',
            'Royalcms\Component\Queue\Failed\FailedJobProviderInterface'     => 'Illuminate\Queue\Failed\FailedJobProviderInterface',
            'Royalcms\Component\Queue\Failed\NullFailedJobProvider'          => 'Illuminate\Queue\Failed\NullFailedJobProvider',
            'Royalcms\Component\Queue\InteractsWithQueue'                    => 'Illuminate\Queue\InteractsWithQueue',
            'Royalcms\Component\Queue\IronQueue'                             => 'Illuminate\Queue\IronQueue',
            'Royalcms\Component\Queue\Jobs\BeanstalkdJob'                    => 'Illuminate\Queue\Jobs\BeanstalkdJob',
            'Royalcms\Component\Queue\Jobs\DatabaseJob'                      => 'Illuminate\Queue\Jobs\DatabaseJob',
            'Royalcms\Component\Queue\Jobs\IronJob'                          => 'Illuminate\Queue\Jobs\IronJob',
            'Royalcms\Component\Queue\Jobs\Job'                              => 'Illuminate\Queue\Jobs\Job',
            'Royalcms\Component\Queue\Jobs\RedisJob'                         => 'Illuminate\Queue\Jobs\RedisJob',
            'Royalcms\Component\Queue\Jobs\SqsJob'                           => 'Illuminate\Queue\Jobs\SqsJob',
            'Royalcms\Component\Queue\Jobs\SyncJob'                          => 'Illuminate\Queue\Jobs\SyncJob',
            'Royalcms\Component\Queue\Listener'                              => 'Illuminate\Queue\Listener',
            'Royalcms\Component\Queue\NullQueue'                             => 'Illuminate\Queue\NullQueue',
            'Royalcms\Component\Queue\Queue'                                 => 'Illuminate\Queue\Queue',
            'Royalcms\Component\Queue\QueueManager'                          => 'Illuminate\Queue\QueueManager',
            'Royalcms\Component\Queue\RedisQueue'                            => 'Illuminate\Queue\RedisQueue',
            'Royalcms\Component\Queue\SerializesAndRestoresModelIdentifiers' => 'Illuminate\Queue\SerializesAndRestoresModelIdentifiers',
            'Royalcms\Component\Queue\SerializesModels'                      => 'Illuminate\Queue\SerializesModels',
            'Royalcms\Component\Queue\SqsQueue'                              => 'Illuminate\Queue\SqsQueue',
            'Royalcms\Component\Queue\SyncQueue'                             => 'Illuminate\Queue\SyncQueue',
            'Royalcms\Component\Queue\Worker'                                => 'Illuminate\Queue\Worker'
        ];
    }

}
