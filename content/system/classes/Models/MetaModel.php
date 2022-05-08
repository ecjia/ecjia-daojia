<?php


namespace Ecjia\System\Models;


use Royalcms\Component\Metable\Meta;

class MetaModel extends Meta
{

    /**
     * AttributeModel constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->connection = config('ecjia.database_connection', 'default');

        parent::__construct($attributes);
    }
}