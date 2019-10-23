<?php namespace Royalcms\Component\WeChat\Message;

/**
 * Class News.
 */
class News extends AbstractMessage
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'news';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
                                'title',
                                'description',
                                'url',
                                'image',
                            ];
    /**
     * Aliases of attribute.
     *
     * @var array
     */
    protected $aliases = [
        'image' => 'pic_url',
    ];
}
