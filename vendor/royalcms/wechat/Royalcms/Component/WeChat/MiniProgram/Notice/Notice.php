<?php

/**
 * Notice.php.
 *
 */

namespace Royalcms\Component\WeChat\MiniProgram\Notice;

use Royalcms\Component\WeChat\Notice\Notice as BaseNotice;

class Notice extends BaseNotice
{
    /**
     * {@inheritdoc}.
     */
    protected $message = [
        'touser' => '',
        'template_id' => '',
        'page' => '',
        'form_id' => '',
        'data' => [],
        'emphasis_keyword' => '',
    ];

    /**
     * {@inheritdoc}.
     */
    protected $defaults = [
        'touser' => '',
        'template_id' => '',
        'form_id' => '',
        'data' => [],
    ];

    /**
     * {@inheritdoc}.
     */
    protected $required = ['touser', 'template_id', 'form_id'];

    /**
     * Send notice message.
     */
    const API_SEND_NOTICE = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send';
}
