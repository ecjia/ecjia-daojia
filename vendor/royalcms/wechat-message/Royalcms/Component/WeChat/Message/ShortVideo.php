<?php namespace Royalcms\Component\WeChat\Message;

/**
 * Class ShortVideo.
 *
 * @property string $title
 * @property string $media_id
 * @property string $description
 * @property string $thumb_media_id
 */
class ShortVideo extends Video
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'shortvideo';
}
