<?php

namespace Royalcms\Component\Foundation;

use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\Contracts\Foundation\Royalcms as RoyalcmsContract;

class ProviderRepository
{
    /**
     * The royalcms implementation.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The path to the manifest file.
     *
     * @var string
     */
    protected $manifestPath;

    /**
     * Default manifest structure.
     *
     * @var array
     */
    protected $default = array('when' => array());

    /**
     * Create a new service repository instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
     * @param  string  $manifestPath
     * @return void
     */
    public function __construct(RoyalcmsContract $royalcms, Filesystem $files, $manifestPath)
    {
        $this->royalcms = $royalcms;
        $this->files = $files;
        $this->manifestPath = $manifestPath;
    }

    /**
     * Register the application service providers.
     *
     * @param  array  $providers
     * @return void
     */
    public function load(array $providers)
    {
        $manifest = $this->loadManifest();

        // First we will load the service manifest, which contains information on all
        // service providers registered with the application and which services it
        // provides. This is used to know which services are "deferred" loaders.
        if ($this->shouldRecompile($manifest, $providers)) {
            $manifest = $this->compileManifest($providers);
        }

        // Next, we will register events to load the providers for each of the events
        // that it has requested. This allows the service provider to defer itself
        // while still getting automatically loaded when a certain event occurs.
        foreach ($manifest['when'] as $provider => $events) {
            $this->registerLoadEvents($provider, $events);
        }

        // We will go ahead and register all of the eagerly loaded providers with the
        // application so their services can be registered with the application as
        // a provided service. Then we will set the deferred service list on it.
        foreach ($manifest['eager'] as $provider) {
            if (class_exists($provider)) {
                $this->royalcms->register($this->createProvider($provider));
            }
        }

        $this->royalcms->addDeferredServices($manifest['deferred']);
    }

    /**
     * Register the load events for the given provider.
     *
     * @param  string  $provider
     * @param  array  $events
     * @return void
     */
    protected function registerLoadEvents($provider, array $events)
    {
        if (count($events) < 1) {
            return;
        }

        $royalcms = $this->royalcms;

        $royalcms->make('events')->listen($events, function () use ($royalcms, $provider) {
            $royalcms->register($provider);
        });
    }

    /**
     * Compile the application manifest file.
     *
     * @param  array  $providers
     * @return array
     */
    protected function compileManifest($providers)
    {
        // The service manifest should contain a list of all of the providers for
        // the application so we can compare it on each request to the service
        // and determine if the manifest should be recompiled or is current.
        $manifest = $this->freshManifest($providers);

        foreach ($providers as $provider) {
            if (! class_exists($provider)) {
                continue;
            }
            
            $instance = $this->createProvider($provider);

            // When recompiling the service manifest, we will spin through each of the
            // providers and check if it's a deferred provider or not. If so we'll
            // add it's provided services to the manifest and note the provider.
            if ($instance->isDeferred()) {
                foreach ($instance->provides() as $service) {
                    $manifest['deferred'][$service] = $provider;
                }

                $manifest['when'][$provider] = $instance->when();
            }

            // If the service providers are not deferred, we will simply add it to an
            // array of eagerly loaded providers that will get registered on every
            // request to this application instead of "lazy" loading every time.
            else {
                $manifest['eager'][] = $provider;
            }
        }

        return $this->writeManifest($manifest);
    }

    /**
     * Create a new provider instance.
     *
     * @param  string  $provider
     * @return \Royalcms\Component\Support\ServiceProvider
     */
    public function createProvider($provider)
    {
        return new $provider($this->royalcms);
    }

    /**
     * Determine if the manifest should be compiled.
     *
     * @param  array  $manifest
     * @param  array  $providers
     * @return bool
     */
    public function shouldRecompile($manifest, $providers)
    {
        return is_null($manifest) || $manifest['providers'] != $providers;
    }

    /**
     * Load the service provider manifest JSON file.
     *
     * @return array|null
     */
    public function loadManifest()
    {
        // The service manifest is a file containing a JSON representation of every
        // service provided by the application and whether its provider is using
        // deferred loading or should be eagerly loaded on each request to us.
        if ($this->files->exists($this->manifestPath)) {
            $manifest = json_decode($this->files->get($this->manifestPath), true);

            if ($manifest) {
                return array_merge($this->default, $manifest);
            }
        }
    }

    /**
     * Write the service manifest file to disk.
     *
     * @param  array  $manifest
     * @return array
     */
    public function writeManifest($manifest)
    {
        $path = dirname($this->manifestPath);
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true);
        }

        $this->files->put(
            $this->manifestPath, json_encode($manifest, JSON_PRETTY_PRINT)
        );

        return array_merge($this->default, $manifest);
    }

    /**
     * Create a fresh service manifest data structure.
     *
     * @param  array  $providers
     * @return array
     */
    protected function freshManifest(array $providers)
    {
        return ['providers' => $providers, 'eager' => [], 'deferred' => []];
    }
}
