<?php namespace Royalcms\Component\WeChat\Message;

/**
 * Class Material.
 */
class Material extends AbstractMessage
{
    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = ['media_id'];

    /**
     * Material constructor.
     *
     * @param string $mediaId
     * @param string $type
     */
    public function __construct($type, $mediaId)
    {
        $this->set('media_id', $mediaId);
        $this->type = $type;
    }
}
