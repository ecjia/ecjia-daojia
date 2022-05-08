<?php

namespace Royalcms\Component\Contracts;

use Royalcms\Component\Support\ServiceProvider;

class ContractsServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->loadAlias();
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
            'Royalcms\Component\Contracts\Auth\Access\Authorizable'           => 'Illuminate\Contracts\Auth\Access\Authorizable',
            'Royalcms\Component\Contracts\Auth\Access\Gate'                   => 'Illuminate\Contracts\Auth\Access\Gate',
            'Royalcms\Component\Contracts\Auth\Authenticatable'               => 'Illuminate\Contracts\Auth\Authenticatable',
            'Royalcms\Component\Contracts\Auth\CanResetPassword'              => 'Illuminate\Contracts\Auth\CanResetPassword',
            'Royalcms\Component\Contracts\Auth\Guard'                         => 'Illuminate\Contracts\Auth\Guard',
            'Royalcms\Component\Contracts\Auth\PasswordBroker'                => 'Illuminate\Contracts\Auth\PasswordBroker',
            'Royalcms\Component\Contracts\Auth\UserProvider'                  => 'Illuminate\Contracts\Auth\UserProvider',
            'Royalcms\Component\Contracts\Broadcasting\Broadcaster'           => 'Illuminate\Contracts\Broadcasting\Broadcaster',
            'Royalcms\Component\Contracts\Broadcasting\Factory'               => 'Illuminate\Contracts\Broadcasting\Factory',
            'Royalcms\Component\Contracts\Broadcasting\ShouldBroadcast'       => 'Illuminate\Contracts\Broadcasting\ShouldBroadcast',
            'Royalcms\Component\Contracts\Broadcasting\ShouldBroadcastNow'    => 'Illuminate\Contracts\Broadcasting\ShouldBroadcastNow',
            'Royalcms\Component\Contracts\Bus\Dispatcher'                     => 'Illuminate\Contracts\Bus\Dispatcher',
            'Royalcms\Component\Contracts\Bus\QueueingDispatcher'             => 'Illuminate\Contracts\Bus\QueueingDispatcher',
            'Royalcms\Component\Contracts\Cache\Factory'                      => 'Illuminate\Contracts\Cache\Factory',
            'Royalcms\Component\Contracts\Cache\Repository'                   => 'Illuminate\Contracts\Cache\Repository',
            'Royalcms\Component\Contracts\Cache\Store'                        => 'Illuminate\Contracts\Cache\Store',
            'Royalcms\Component\Contracts\Config\Repository'                  => 'Illuminate\Contracts\Config\Repository',
            'Royalcms\Component\Contracts\Container\ContextualBindingBuilder' => 'Illuminate\Contracts\Container\ContextualBindingBuilder',
            'Royalcms\Component\Contracts\Cookie\Factory'                     => 'Illuminate\Contracts\Cookie\Factory',
            'Royalcms\Component\Contracts\Cookie\QueueingFactory'             => 'Illuminate\Contracts\Cookie\QueueingFactory',
            'Royalcms\Component\Contracts\Database\ModelIdentifier'           => 'Illuminate\Contracts\Database\ModelIdentifier',
            'Royalcms\Component\Contracts\Debug\ExceptionHandler'             => 'Illuminate\Contracts\Debug\ExceptionHandler',
            'Royalcms\Component\Contracts\Encryption\DecryptException'        => 'Illuminate\Contracts\Encryption\DecryptException',
            'Royalcms\Component\Contracts\Encryption\Encrypter'               => 'Illuminate\Contracts\Encryption\Encrypter',
            'Royalcms\Component\Contracts\Encryption\EncryptException'        => 'Illuminate\Contracts\Encryption\EncryptException',
            'Royalcms\Component\Contracts\Filesystem\Cloud'                   => 'Illuminate\Contracts\Filesystem\Cloud',
            'Royalcms\Component\Contracts\Filesystem\Factory'                 => 'Illuminate\Contracts\Filesystem\Factory',
            'Royalcms\Component\Contracts\Filesystem\FileNotFoundException'   => 'Illuminate\Contracts\Filesystem\FileNotFoundException',
            'Royalcms\Component\Contracts\Filesystem\Filesystem'              => 'Illuminate\Contracts\Filesystem\Filesystem',
            'Royalcms\Component\Contracts\Hashing\Hasher'                     => 'Illuminate\Contracts\Hashing\Hasher',
            'Royalcms\Component\Contracts\Notifications\Dispatcher'           => 'Illuminate\Contracts\Notifications\Dispatcher',
            'Royalcms\Component\Contracts\Notifications\Factory'              => 'Illuminate\Contracts\Notifications\Factory',
            'Royalcms\Component\Contracts\Pagination\LengthAwarePaginator'    => 'Illuminate\Contracts\Pagination\LengthAwarePaginator',
            'Royalcms\Component\Contracts\Pagination\Paginator'               => 'Illuminate\Contracts\Pagination\Paginator',
            'Royalcms\Component\Contracts\Pipeline\Hub'                       => 'Illuminate\Contracts\Pipeline\Hub',
            'Royalcms\Component\Contracts\Pipeline\Pipeline'                  => 'Illuminate\Contracts\Pipeline\Pipeline',
            'Royalcms\Component\Contracts\Queue\EntityNotFoundException'      => 'Illuminate\Contracts\Queue\EntityNotFoundException',
            'Royalcms\Component\Contracts\Queue\EntityResolver'               => 'Illuminate\Contracts\Queue\EntityResolver',
            'Royalcms\Component\Contracts\Queue\Factory'                      => 'Illuminate\Contracts\Queue\Factory',
            'Royalcms\Component\Contracts\Queue\Job'                          => 'Illuminate\Contracts\Queue\Job',
            'Royalcms\Component\Contracts\Queue\Monitor'                      => 'Illuminate\Contracts\Queue\Monitor',
            'Royalcms\Component\Contracts\Queue\Queue'                        => 'Illuminate\Contracts\Queue\Queue',
            'Royalcms\Component\Contracts\Queue\QueueableEntity'              => 'Illuminate\Contracts\Queue\QueueableEntity',
            'Royalcms\Component\Contracts\Queue\ShouldQueue'                  => 'Illuminate\Contracts\Queue\ShouldQueue',
            'Royalcms\Component\Contracts\Routing\UrlGenerator'               => 'Illuminate\Contracts\Routing\UrlGenerator',
            'Royalcms\Component\Contracts\Routing\UrlRoutable'                => 'Illuminate\Contracts\Routing\UrlRoutable',
            'Royalcms\Component\Contracts\Support\Arrayable'                  => 'Illuminate\Contracts\Support\Arrayable',
            'Royalcms\Component\Contracts\Support\Htmlable'                   => 'Illuminate\Contracts\Support\Htmlable',
            'Royalcms\Component\Contracts\Support\Jsonable'                   => 'Illuminate\Contracts\Support\Jsonable',
            'Royalcms\Component\Contracts\Support\MessageBag'                 => 'Illuminate\Contracts\Support\MessageBag',
            'Royalcms\Component\Contracts\Support\MessageProvider'            => 'Illuminate\Contracts\Support\MessageProvider',
            'Royalcms\Component\Contracts\Support\Renderable'                 => 'Illuminate\Contracts\Support\Renderable',
            'Royalcms\Component\Contracts\Validation\Factory'                 => 'Illuminate\Contracts\Validation\Factory',
            'Royalcms\Component\Contracts\Validation\ValidatesWhenResolved'   => 'Illuminate\Contracts\Validation\ValidatesWhenResolved',
            'Royalcms\Component\Contracts\Validation\Validator'               => 'Illuminate\Contracts\Validation\Validator',
            'Royalcms\Component\Contracts\View\Engine'                        => 'Illuminate\Contracts\View\Engine',
            'Royalcms\Component\Contracts\View\View'                          => 'Illuminate\Contracts\View\View'
        ];

    }

}
