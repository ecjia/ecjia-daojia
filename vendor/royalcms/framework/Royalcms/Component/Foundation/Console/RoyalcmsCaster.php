<?php

namespace Royalcms\Component\Foundation\Console;

use Exception;
use Royalcms\Component\Support\Collection;
use Royalcms\Component\Foundation\Application;
use Royalcms\Component\Database\Eloquent\Model;
use Symfony\Component\VarDumper\Caster\Caster;

class RoyalcmsCaster
{
    /**
     * Royalcms application methods to include in the presenter.
     *
     * @var array
     */
    private static $appProperties = [
        'configurationIsCached',
        'environment',
        'environmentFile',
        'isLocal',
        'routesAreCached',
        'runningUnitTests',
        'version',
        'path',
        'basePath',
        'configPath',
        'databasePath',
        'langPath',
        'publicPath',
        'storagePath',
    ];

    /**
     * Get an array representing the properties of an application.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
     * @return array
     */
    public static function castApplication(Royalcms $royalcms)
    {
        $results = [];

        foreach (self::$appProperties as $property) {
            try {
                $val = $royalcms->$property();

                if (! is_null($val)) {
                    $results[Caster::PREFIX_VIRTUAL.$property] = $val;
                }
            } catch (Exception $e) {
                //
            }
        }

        return $results;
    }

    /**
     * Get an array representing the properties of a collection.
     *
     * @param  \Royalcms\Component\Support\Collection  $collection
     * @return array
     */
    public static function castCollection(Collection $collection)
    {
        return [
            Caster::PREFIX_VIRTUAL.'all' => $collection->all(),
        ];
    }

    /**
     * Get an array representing the properties of a model.
     *
     * @param  \Royalcms\Component\Database\Eloquent\Model  $model
     * @return array
     */
    public static function castModel(Model $model)
    {
        $attributes = array_merge(
            $model->getAttributes(), $model->getRelations()
        );

        $visible = array_flip(
            $model->getVisible() ?: array_diff(array_keys($attributes), $model->getHidden())
        );

        $results = [];

        foreach (array_intersect_key($attributes, $visible) as $key => $value) {
            $results[(isset($visible[$key]) ? Caster::PREFIX_VIRTUAL : Caster::PREFIX_PROTECTED).$key] = $value;
        }

        return $results;
    }
}
