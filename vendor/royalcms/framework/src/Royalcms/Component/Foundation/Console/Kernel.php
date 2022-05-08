<?php

namespace Royalcms\Component\Foundation\Console;

use Exception;
use Illuminate\Support\Env;
use Throwable;
use Royalcms\Component\Contracts\Events\Dispatcher;
use Royalcms\Component\Console\Scheduling\Schedule;
use Royalcms\Component\Console\Royalcms as Artisan;
use Royalcms\Component\Contracts\Foundation\Royalcms;
use Royalcms\Component\Contracts\Console\Kernel as KernelContract;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Illuminate\Foundation\Console\Kernel as LaravelKernel;

class Kernel extends LaravelKernel implements KernelContract
{
    /**
     * The application implementation.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * The event dispatcher implementation.
     *
     * @var \Royalcms\Component\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * The Artisan application instance.
     *
     * @var \Royalcms\Component\Console\Royalcms
     */
    protected $artisan;

//    /**
//     * The Artisan commands provided by the application.
//     *
//     * @var array
//     */
//    protected $commands = [];

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        'Royalcms\Component\Foundation\Bootstrap\Starting',
        'Royalcms\Component\Foundation\Bootstrap\LoadEnvironmentVariables',
        'Royalcms\Component\Foundation\Bootstrap\LoadConfiguration',
        'Royalcms\Component\Foundation\Bootstrap\RegisterNamespaces',
//        'Royalcms\Component\Foundation\Bootstrap\ConfigureLogging',
        'Royalcms\Component\Foundation\Bootstrap\HandleExceptions',
        'Royalcms\Component\Foundation\Bootstrap\RegisterFacades',
        'Royalcms\Component\Foundation\Bootstrap\SetRequestForConsole',
        'Royalcms\Component\Foundation\Bootstrap\RegisterProviders',
        'Royalcms\Component\Foundation\Bootstrap\BootProviders',
        'Royalcms\Component\Foundation\Bootstrap\CommandBooted',
    ];

    /**
     * Create a new console kernel instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function __construct(Royalcms $royalcms, Dispatcher $events)
    {
        if (! defined('ARTISAN_BINARY')) {
            define('ARTISAN_BINARY', 'royalcms');
        }

        $this->royalcms = $royalcms;
        $this->events = $events;
        $this->app = $royalcms;

        $this->royalcms->booted(function ($royalcms) {

            $this->defineConsoleSchedule();

        });
    }

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function defineConsoleSchedule()
    {
        $this->royalcms->singleton(Schedule::class, function ($app) {
            return tap(new Schedule($this->scheduleTimezone()), function ($schedule) {
                $this->schedule($schedule->useCache($this->scheduleCache()));
            });
        });
    }

    /**
     * Get the name of the cache store that should manage scheduling mutexes.
     *
     * @return string
     */
    protected function scheduleCache()
    {
        return Env::get('SCHEDULE_CACHE_DRIVER');
    }

    /**
     * Run the console application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    public function handle($input, $output = null)
    {
        try {
            $this->bootstrap();

            return $this->getArtisan()->run($input, $output);
        } catch (Exception $e) {
            $this->reportException($e);

            $this->renderException($output, $e);

            return 1;
        } catch (Throwable $e) {
            $e = new FatalThrowableError($e);

            $this->reportException($e);

            $this->renderException($output, $e);

            return 1;
        }
    }

    /**
     * Terminate the application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  int  $status
     * @return void
     */
    public function terminate($input, $status)
    {
        $this->royalcms->terminate();
    }

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        $config = $this->royalcms['config'];

        return $config->get('app.schedule_timezone', $config->get('app.timezone'));
    }

    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return int
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        $this->bootstrap();

        return $this->getArtisan()->call($command, $parameters, $outputBuffer);
    }

    /**
     * Queue the given console command.
     *
     * @param  string  $command
     * @param  array   $parameters
     * @return void
     */
    public function queue($command, array $parameters = [])
    {
        $this->royalcms['Royalcms\Component\Contracts\Queue\Queue']->push(
            'Royalcms\Component\Foundation\Console\QueuedJob', func_get_args()
        );
    }

    /**
     * Get all of the commands registered with the console.
     *
     * @return array
     */
    public function all()
    {
        $this->bootstrap();

        return $this->getArtisan()->all();
    }

    /**
     * Get the output for the last run command.
     *
     * @return string
     */
    public function output()
    {
        $this->bootstrap();

        return $this->getArtisan()->output();
    }

    /**
     * Add a command to the console.
     *
     * @param  \Symfony\Component\Console\Command\Command  $command
     * @return \Symfony\Component\Console\Command\Command
     */
    public function add(SymfonyCommand $command)
    {
        $this->bootstrap();

        return $this->getArtisan()->add($command);
    }

    /**
     * Bootstrap the application for artisan commands.
     *
     * @return void
     */
    public function bootstrap()
    {
        if (! $this->royalcms->hasBeenBootstrapped()) {
            $this->royalcms->bootstrapWith($this->bootstrappers());
        }

        // If we are calling an arbitrary command from within the application, we'll load
        // all of the available deferred providers which will make all of the commands
        // available to an application. Otherwise the command will not be available.
        $this->royalcms->loadDeferredProviders();
    }

    /**
     * Get the Artisan application instance.
     *
     * @return \Royalcms\Component\Console\Royalcms
     */
    protected function getArtisan()
    {
        if (is_null($this->artisan)) {
            return $this->artisan = (new Artisan($this->royalcms, $this->events, $this->royalcms->version()))
                                ->resolveCommands($this->commands);
        }

        return $this->artisan;
    }

    /**
     * Get the bootstrap classes for the application.
     *
     * @return array
     */
    protected function bootstrappers()
    {
        return $this->bootstrappers;
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Throwable  $e
     * @return void
     */
    protected function reportException(Throwable $e)
    {
        $this->royalcms['Royalcms\Component\Contracts\Debug\ExceptionHandler']->report($e);
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Throwable  $e
     * @return void
     */
    protected function renderException($output, Throwable $e)
    {
        $this->royalcms['Royalcms\Component\Contracts\Debug\ExceptionHandler']->renderForConsole($output, $e);
    }
}
