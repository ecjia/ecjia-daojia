<?php

namespace Royalcms\Component\Uploader;

use Royalcms\Component\Support\Str;
use InvalidArgumentException;
use Royalcms\Component\Contracts\Container\Container;
use Royalcms\Component\Uploader\Contracts\Factory as FactoryContract;

class UploaderManager implements FactoryContract
{
    /**
     * The Container implementation.
     *
     * @var \Royalcms\Component\Contracts\Container\Container
     */
    protected $royalcms;

    /**
     * The array of file providers.
     *
     * @var array
     */
    protected $providers = [
        'local' => '\Royalcms\Component\Uploader\Providers\LocalProvider',
        'request' => '\Royalcms\Component\Uploader\Providers\HttpRequestProvider',
    ];

    /**
     * The array of resolved file providers.
     *
     * @var array
     */
    protected $resolvedProviders = [];

    /**
     * Create a new UploaderManager instance.
     *
     * @param  \Royalcms\Component\Contracts\Container\Container  $app
     * @return void
     */
    public function __construct(Container $royalcms)
    {
        $this->royalcms = $royalcms;
    }

    /**
     * Specify where the file is provided.
     *
     * @param  string|null  $provider
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function from($provider = null)
    {
        $provider = $provider ?: $this->getDefaultProvider();

        return new Uploader(
            $this->royalcms->make('config'), $this->royalcms->make('filesystem'), $this->createProviderInstance($provider)
        );
    }

    /**
     * Get the default file provider name.
     *
     * @return string
     */
    public function getDefaultProvider()
    {
        return $this->royalcms->make('config')['uploader.default'];
    }

    /**
     * Create the file provider instance.
     *
     * @param  string  $provider
     * @return \Royalcms\Component\Uploader\Contracts\Provider
     *
     * @throws \InvalidArgumentException
     */
    protected function createProviderInstance($provider)
    {
        if (! isset($this->providers[$provider])) {
            throw new InvalidArgumentException("File provider [{$provider}] is invalid.");
        }

        if (isset($this->resolvedProviders[$provider])) {
            return $this->resolvedProviders[$provider];
        }

        return $this->resolvedProviders[$provider] = $this->royalcms->make($this->providers[$provider]);
    }

    /**
     * Handle dynamic "from" method calls.
     *
     * @param  string  $from
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    protected function dynamicFrom($from)
    {
        $provider = Str::snake(substr($from, 4));

        return $this->from($provider);
    }

    /**
     * Handle dynamic method calls into the Uploader instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'from')) {
            return $this->dynamicFrom($method);
        }

        return call_user_func_array([$this->from(), $method], $parameters);
    }
}
