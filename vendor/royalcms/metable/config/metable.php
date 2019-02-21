<?php

return [
    /*
     * Model class to use for Meta.
     */
    'model' => Royalcms\Component\Metable\Meta::class,

    /*
     * List of handlers for recognized data types.
     *
     * Handlers will be evaluated in order, so a value will be handled
     * by the first appropriate handler in the list.
     */
    'datatypes' => [
        Royalcms\Component\Metable\DataType\BooleanHandler::class,
        Royalcms\Component\Metable\DataType\NullHandler::class,
        Royalcms\Component\Metable\DataType\IntegerHandler::class,
        Royalcms\Component\Metable\DataType\FloatHandler::class,
        Royalcms\Component\Metable\DataType\StringHandler::class,
        Royalcms\Component\Metable\DataType\DateTimeHandler::class,
        Royalcms\Component\Metable\DataType\ArrayHandler::class,
        Royalcms\Component\Metable\DataType\ModelHandler::class,
        Royalcms\Component\Metable\DataType\ModelCollectionHandler::class,
        Royalcms\Component\Metable\DataType\SerializableHandler::class,
        Royalcms\Component\Metable\DataType\ObjectHandler::class,
    ],
];
