<?php namespace Royalcms\Component\WeChat\Message;

/**
 * Class Article.
 */
class Article extends AbstractMessage
{
    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
                                'thumb_media_id',
                                'author',
                                'title',
                                'content',
                                'digest',
                                'source_url',
                                'show_cover',
                            ];

    /**
     * Aliases of attribute.
     *
     * @var array
     */
    protected $aliases = [
        'source_url' => 'content_source_url',
        'show_cover' => 'show_cover_pic',
    ];
}
