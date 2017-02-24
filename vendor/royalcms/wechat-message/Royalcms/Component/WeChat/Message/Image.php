<?php namespace Royalcms\Component\WeChat\Message;

/**
 * Class Image.
 *
 * @property string $media_id
 */
class Image extends AbstractMessage
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'image';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = ['media_id'];

    /**
     * Set media_id.
     *
     * @param string $mediaId
     *
     * @return Image
     */
    public function media($mediaId)
    {
        $this->setAttribute('media_id', $mediaId);

        return $this;
    }
}
