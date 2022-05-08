<?php

declare(strict_types=1);

namespace Royalcms\Laravel\JsonRpcServer;

use Royalcms\Laravel\JsonRpcServer\Http\AuthUser\AuthUser;
use Royalcms\Laravel\JsonRpcServer\Http\AuthUser\AuthUserInterface;
use Royalcms\Laravel\JsonRpcServer\Router\Router;
use Royalcms\Laravel\JsonRpcServer\Router\RouterInterface;
use Royalcms\Laravel\JsonRpcServer\Factories\RequestFactory;
use Royalcms\Laravel\JsonRpcServer\Factories\FactoryInterface;

class JsonRpcServerServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publish();

        //bind class
        $this->app->bind(AuthUserInterface::class, AuthUser::class);
    }

    /**
     * Publish config file.
     */
    protected function publish()
    {
        $source = realpath($raw = __DIR__.'/../config/basic-auth.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('basic-auth.php'),
            ]);
        }

        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom($source, 'basic-auth');
        }
    }

    /**
     * Register RPC services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerJsonRpcRequestsFactory();
        $this->registerRpcKernel();
        $this->registerRpcRouter();
    }

    /**
     * Register Json RPC requests factory.
     *
     * @return void
     */
    protected function registerJsonRpcRequestsFactory(): void
    {
        $this->app->bindIf(FactoryInterface::class, RequestFactory::class);
    }

    /**
     * Register RPC kernel.
     *
     * @return void
     */
    protected function registerRpcKernel(): void
    {
        $this->app->singleton(KernelInterface::class, Kernel::class);
    }

    /**
     * Register RPC router.
     *
     * @return void
     */
    protected function registerRpcRouter(): void
    {
        $this->app->singleton(RouterInterface::class, Router::class);
    }
}
