<?php

namespace Royalcms\Component\Pagination;

class PaginationServiceProvider extends \Illuminate\Pagination\PaginationServiceProvider
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
        parent::register();

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
            'Royalcms\Component\Pagination\AbstractPaginator'    => 'Illuminate\Pagination\AbstractPaginator',
            'Royalcms\Component\Pagination\LengthAwarePaginator' => 'Illuminate\Pagination\LengthAwarePaginator',
            'Royalcms\Component\Pagination\Paginator'            => 'Illuminate\Pagination\Paginator',
            'Royalcms\Component\Pagination\UrlWindow'            => 'Illuminate\Pagination\UrlWindow'
        ];
    }


}
