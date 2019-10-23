<?php namespace Royalcms\Component\WeChat\Message;

/**
 * Class Text.
 *
 * @property string $content
 */
class Text extends AbstractMessage
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'text';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = ['content'];
}
