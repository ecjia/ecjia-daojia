<?php


namespace Royalcms\Component\Foundation\Optimize;


use Exception;
use Royalcms\Component\Foundation\Royalcms;

class ClassAliasLoader
{

    protected $providers = [
        'Royalcms\Component\Auth\AuthServiceProvider',
        'Royalcms\Component\Broadcasting\BroadcastServiceProvider',
        'Royalcms\Component\Bus\BusServiceProvider',
        'Royalcms\Component\Cache\CacheServiceProvider',
        'Royalcms\Component\Container\ContainerServiceProvider',
        'Royalcms\Component\Contracts\ContractsServiceProvider',
        'Royalcms\Component\Cookie\CookieServiceProvider',
        'Royalcms\Component\Database\DatabaseServiceProvider',
        'Royalcms\Component\Filesystem\FilesystemServiceProvider',
        'Royalcms\Component\Http\HttpServiceProvider',
        'Royalcms\Component\Notifications\NotificationServiceProvider',
        'Royalcms\Component\Pagination\PaginationServiceProvider',
        'Royalcms\Component\Pipeline\PipelineServiceProvider',
        'Royalcms\Component\Queue\QueueServiceProvider',
        'Royalcms\Component\Redis\RedisServiceProvider',
        'Royalcms\Component\Routing\RoutingServiceProvider',
        'Royalcms\Component\Session\SessionServiceProvider',
        'Royalcms\Component\Support\SupportServiceProvider',
        'Royalcms\Component\Translation\TranslationServiceProvider',
        'Royalcms\Component\Validation\ValidationServiceProvider',
        'Royalcms\Component\View\ViewServiceProvider',
    ];

    /**
     * The composer instance.
     *
     * @var \Royalcms\Component\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * The path to the manifest file.
     *
     * @var string
     */
    protected $manifestPath;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new optimize command instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct(Royalcms $royalcms)
    {
        $this->royalcms = $royalcms;

        $this->manifestPath = $this->royalcms->getCachedAliasesPath();

        $this->files = $this->royalcms['files'];
    }

    /**
     * @return \Illuminate\Support\Collection|\Royalcms\Component\Support\Collection
     * @throws Exception
     */
    public function loadAlias()
    {
        $manifest = $this->loadManifest();

        if ($this->shouldRecompile($manifest)) {
            $manifest = $this->compile();
        }

        return $manifest;
    }


    /**
     * @return \Illuminate\Support\Collection|\Royalcms\Component\Support\Collection
     * @throws Exception
     */
    public function compile()
    {
        $files = $this->getClassFiles();

        $manifest = collect($files);

        $this->writeManifest($manifest);

        return $manifest;
    }

    /**
     * Get the classes that should be combined and compiled.
     *
     * @return array
     */
    protected function getClassFiles()
    {
        $royalcms = $this->royalcms;

        $files = [];

        foreach ($this->providers as $provider) {
            $files = array_merge($files, $this->getProviderCompiles($provider));
        }

        return $files;
    }


    /**
     * @param $provider
     * @return mixed
     */
    protected function getProviderCompiles($provider)
    {
        return forward_static_call([$provider, 'aliases']) ?: [];
    }

    /**
     * Determine if the manifest should be compiled.
     *
     * @param  array  $manifest
     * @param  array  $providers
     * @return bool
     */
    public function shouldRecompile($manifest)
    {
        return is_null($manifest);
    }

    /**
     * Load the service provider manifest file.
     *
     * @return array|null
     */
    public function loadManifest()
    {
        // The service manifest is a file containing a JSON representation of every
        // service provided by the application and whether its provider is using
        // deferred loading or should be eagerly loaded on each request to us.
        if ($this->files->exists($this->manifestPath)) {
            $manifest = $this->files->getRequire($this->manifestPath);

            if ($manifest) {
                return collect($manifest);
            }
        }
    }

    /**
     * Write the service manifest file to disk.
     *
     * @param  array  $manifest
     * @return array
     *
     * @throws \Exception
     */
    public function writeManifest($manifest)
    {
        if (! is_writable($dirname = dirname($this->manifestPath))) {
            throw new Exception("The {$dirname} directory must be present and writable.");
        }

        $this->files->replace(
            $this->manifestPath, '<?php return '.var_export($manifest->all(), true).';'
        );

        return $manifest;
    }

}