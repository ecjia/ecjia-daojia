<?php

namespace Royalcms\Component\Metable;

use Royalcms\Component\Database\Eloquent\Model;
use Royalcms\Component\Database\Eloquent\Relations\MorphTo;
use Royalcms\Component\Metable\DataType\Registry;

/**
 * Model for storing meta data.
 *
 */
class Meta extends Model
{
    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * {@inheritdoc}
     */
    protected $table = 'meta';

    /**
     * {@inheritdoc}
     */
    protected $guarded = ['id', 'metable_type', 'metable_id', 'type'];

    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        'type'  => 'null',
        'value' => '',
    ];

    /**
     * Cache of unserialized value.
     *
     * @var mixed
     */
    protected $cachedValue;

    /**
     * Metable Relation.
     *
     * @return MorphTo
     */
    public function metable()
    {
        return $this->morphTo();
    }

    /**
     * Accessor for value.
     *
     * Will unserialize the value before returning it.
     *
     * Successive access will be loaded from cache.
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        if (!isset($this->cachedValue)) {
            $this->cachedValue = $this->getDataTypeRegistry()
                ->getHandlerForType($this->type)
                ->unserializeValue($this->attributes['value']);
        }

        return $this->cachedValue;
    }

    /**
     * Mutator for value.
     *
     * The `type` attribute will be automatically updated to match the datatype of the input.
     *
     * @param mixed $value
     */
    public function setValueAttribute($value)
    {
        $registry = $this->getDataTypeRegistry();

        $this->attributes['type'] = $registry->getTypeForValue($value);
        $this->attributes['value'] = $registry->getHandlerForType($this->type)
            ->serializeValue($value);

        $this->cachedValue = null;
    }

    /**
     * Retrieve the underlying serialized value.
     *
     * @return string
     */
    public function getRawValue()
    {
        return $this->attributes['value'];
    }

    /**
     * Load the datatype Registry from the container.
     *
     * @return Registry
     */
    protected function getDataTypeRegistry()
    {
        return royalcms('metable.datatype.registry');
    }
}
