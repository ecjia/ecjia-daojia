<?php namespace Royalcms\Component\Queue;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Queue\Console\WorkCommand;
use Royalcms\Component\Queue\Console\ListenCommand;
use Royalcms\Component\Queue\Connectors\SqsConnector;
use Royalcms\Component\Queue\Console\SubscribeCommand;
use Royalcms\Component\Queue\Connectors\SyncConnector;
use Royalcms\Component\Queue\Connectors\IronConnector;
use Royalcms\Component\Queue\Connectors\RedisConnector;
use Royalcms\Component\Queue\Connectors\BeanstalkdConnector;
use Royalcms\Component\Queue\Failed\DatabaseFailedJobProvider;

class QueueServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerManager();

		$this->registerWorker();

		$this->registerListener();

		$this->registerSubscriber();

		$this->registerFailedJobServices();
	}

	/**
	 * Register the queue manager.
	 *
	 * @return void
	 */
	protected function registerManager()
	{
		$me = $this;

		$this->royalcms->bindShared('queue', function($royalcms) use ($me)
		{
			// Once we have an instance of the queue manager, we will register the various
			// resolvers for the queue connectors. These connectors are responsible for
			// creating the classes that accept queue configs and instantiate queues.
			$manager = new QueueManager($royalcms);

			$me->registerConnectors($manager);

			return $manager;
		});
	}

	/**
	 * Register the queue worker.
	 *
	 * @return void
	 */
	protected function registerWorker()
	{
		$this->registerWorkCommand();

		$this->royalcms->bindShared('queue.worker', function($royalcms)
		{
			return new Worker($royalcms['queue'], $royalcms['queue.failer'], $royalcms['events']);
		});
	}

	/**
	 * Register the queue worker console command.
	 *
	 * @return void
	 */
	protected function registerWorkCommand()
	{
		$this->royalcms->bindShared('command.queue.work', function($royalcms)
		{
			return new WorkCommand($royalcms['queue.worker']);
		});

		$this->commands('command.queue.work');
	}

	/**
	 * Register the queue listener.
	 *
	 * @return void
	 */
	protected function registerListener()
	{
		$this->registerListenCommand();

		$this->royalcms->bindShared('queue.listener', function($royalcms)
		{
			return new Listener($royalcms['path.base']);
		});
	}

	/**
	 * Register the queue listener console command.
	 *
	 * @return void
	 */
	protected function registerListenCommand()
	{
		$this->royalcms->bindShared('command.queue.listen', function($royalcms)
		{
			return new ListenCommand($royalcms['queue.listener']);
		});

		$this->commands('command.queue.listen');
	}

	/**
	 * Register the push queue subscribe command.
	 *
	 * @return void
	 */
	protected function registerSubscriber()
	{
		$this->royalcms->bindShared('command.queue.subscribe', function($royalcms)
		{
			return new SubscribeCommand;
		});

		$this->commands('command.queue.subscribe');
	}

	/**
	 * Register the connectors on the queue manager.
	 *
	 * @param  \Royalcms\Component\Queue\QueueManager  $manager
	 * @return void
	 */
	public function registerConnectors($manager)
	{
		foreach (array('Sync', 'Beanstalkd', 'Redis', 'Sqs', 'Iron') as $connector)
		{
			$this->{"register{$connector}Connector"}($manager);
		}
	}

	/**
	 * Register the Sync queue connector.
	 *
	 * @param  \Royalcms\Component\Queue\QueueManager  $manager
	 * @return void
	 */
	protected function registerSyncConnector($manager)
	{
		$manager->addConnector('sync', function()
		{
			return new SyncConnector;
		});
	}

	/**
	 * Register the Beanstalkd queue connector.
	 *
	 * @param  \Royalcms\Component\Queue\QueueManager  $manager
	 * @return void
	 */
	protected function registerBeanstalkdConnector($manager)
	{
		$manager->addConnector('beanstalkd', function()
		{
			return new BeanstalkdConnector;
		});
	}

	/**
	 * Register the Redis queue connector.
	 *
	 * @param  \Royalcms\Component\Queue\QueueManager  $manager
	 * @return void
	 */
	protected function registerRedisConnector($manager)
	{
		$royalcms = $this->royalcms;

		$manager->addConnector('redis', function() use ($royalcms)
		{
			return new RedisConnector($royalcms['redis']);
		});
	}

	/**
	 * Register the Amazon SQS queue connector.
	 *
	 * @param  \Royalcms\Component\Queue\QueueManager  $manager
	 * @return void
	 */
	protected function registerSqsConnector($manager)
	{
		$manager->addConnector('sqs', function()
		{
			return new SqsConnector;
		});
	}

	/**
	 * Register the IronMQ queue connector.
	 *
	 * @param  \Royalcms\Component\Queue\QueueManager  $manager
	 * @return void
	 */
	protected function registerIronConnector($manager)
	{
		$royalcms = $this->royalcms;

		$manager->addConnector('iron', function() use ($royalcms)
		{
			return new IronConnector($royalcms['encrypter'], $royalcms['request']);
		});

		$this->registerIronRequestBinder();
	}

	/**
	 * Register the request rebinding event for the Iron queue.
	 *
	 * @return void
	 */
	protected function registerIronRequestBinder()
	{
		$this->royalcms->rebinding('request', function($royalcms, $request)
		{
			if ($royalcms['queue']->connected('iron'))
			{
				$royalcms['queue']->connection('iron')->setRequest($request);
			}
		});
	}

	/**
	 * Register the failed job services.
	 *
	 * @return void
	 */
	protected function registerFailedJobServices()
	{
		$this->royalcms->bindShared('queue.failer', function($royalcms)
		{
			$config = $royalcms['config']['queue.failed'];

			return new DatabaseFailedJobProvider($royalcms['db'], $config['database'], $config['table']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'queue', 'queue.worker', 'queue.listener', 'queue.failer',
			'command.queue.work', 'command.queue.listen', 'command.queue.subscribe'
		);
	}

}
