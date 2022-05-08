<?php

namespace Royalcms\Component\Broadcasting;


class BroadcastServiceProvider extends \Illuminate\Broadcasting\BroadcastServiceProvider
{
    /**
     * The application instance.
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms $royalcms
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
            'Royalcms\Component\Broadcasting\BroadcastEvent'                 => 'Illuminate\Broadcasting\BroadcastEvent',
            'Royalcms\Component\Broadcasting\BroadcastManager'               => 'Illuminate\Broadcasting\BroadcastManager',
            'Royalcms\Component\Broadcasting\BroadcastManager'               => 'Illuminate\Broadcasting\PrivateChannel',
            'Royalcms\Component\Broadcasting\Broadcasters\LogBroadcaster'    => 'Illuminate\Broadcasting\Broadcasters\LogBroadcaster',
            'Royalcms\Component\Broadcasting\Broadcasters\PusherBroadcaster' => 'Illuminate\Broadcasting\Broadcasters\PusherBroadcaster',
            'Royalcms\Component\Broadcasting\Broadcasters\RedisBroadcaster'  => 'Illuminate\Broadcasting\Broadcasters\RedisBroadcaster'
        ];
    }
}
