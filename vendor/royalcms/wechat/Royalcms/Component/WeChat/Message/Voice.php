<?php namespace Royalcms\Component\WeChat\Message;

/**
 * Class Voice.
 *
 * @property string $media_id
 */
class Voice extends AbstractMessage
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'voice';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
                                'media_id',
                                'recognition',
                            ];

    /**
     * Set media id.
     *
     * @param string $mediaId
     *
     * @return Voice
     */
    public function media($mediaId)
    {
        $this->setAttribute('media_id', $mediaId);

        return $this;
    }
}
