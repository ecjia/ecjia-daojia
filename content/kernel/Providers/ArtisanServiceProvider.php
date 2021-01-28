<?php
namespace Ecjia\Kernel\Providers;

use Royalcms\Component\Foundation\Providers\ArtisanServiceProvider as RoyalcmsArtisanServiceProvider;

class ArtisanServiceProvider extends RoyalcmsArtisanServiceProvider
{

    /**
     * The commands to be registered.
     * @var array
     */
    protected $commands = [
        'QueueFailed' => 'command.queue.failed',
        'QueueFlush' => 'command.queue.flush',
        'QueueForget' => 'command.queue.forget',
        'QueueListen' => 'command.queue.listen',
        'QueueRestart' => 'command.queue.restart',
        'QueueRetry' => 'command.queue.retry',
        'QueueWork' => 'command.queue.work',
    ];


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMyCommands();
    }

    /**
     * Register the Commands
     */
    protected function registerMyCommands()
    {
        $commands = config('commands');

        $this->commands($commands);
    }

}