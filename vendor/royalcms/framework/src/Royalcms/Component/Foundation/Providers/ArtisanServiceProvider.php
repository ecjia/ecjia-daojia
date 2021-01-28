<?php

namespace Royalcms\Component\Foundation\Providers;

use Illuminate\Foundation\Providers\ArtisanServiceProvider as LaravelArtisanServiceProvider;

class ArtisanServiceProvider extends LaravelArtisanServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * The commands to be registered.
     * @var array
     */
    protected $commands = [

    ];

    /**
     * The commands to be registered.
     * @var array
     */
    protected $devCommands = [

    ];

    /**
     * Create a new service provider instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }

}
