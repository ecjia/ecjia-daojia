<?php

namespace Royalcms\Component\Http;

use Royalcms\Component\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
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
            'Royalcms\Component\Http\File'                                     => 'Illuminate\Http\File',
            'Royalcms\Component\Http\FileHelpers'                              => 'Illuminate\Http\FileHelpers',
            'Royalcms\Component\Http\JsonResponse'                             => 'Illuminate\Http\JsonResponse',
            'Royalcms\Component\Http\Middleware\CheckResponseForModifications' => 'Illuminate\Http\Middleware\CheckResponseForModifications',
            'Royalcms\Component\Http\Middleware\FrameGuard'                    => 'Illuminate\Http\Middleware\FrameGuard',
            'Royalcms\Component\Http\RedirectResponse'                         => 'Illuminate\Http\RedirectResponse',
            'Royalcms\Component\Http\Request'                                  => 'Illuminate\Http\Request',
            'Royalcms\Component\Http\Response'                                 => 'Illuminate\Http\Response',
            'Royalcms\Component\Http\ResponseTrait'                            => 'Illuminate\Http\ResponseTrait',
            'Royalcms\Component\Http\Testing\File'                             => 'Illuminate\Http\Testing\File',
            'Royalcms\Component\Http\Testing\FileFactory'                      => 'Illuminate\Http\Testing\FileFactory',
            'Royalcms\Component\Http\Testing\MimeType'                         => 'Illuminate\Http\Testing\MimeType',
            'Royalcms\Component\Http\UploadedFile'                             => 'Illuminate\Http\UploadedFile'
        ];
    }

}
