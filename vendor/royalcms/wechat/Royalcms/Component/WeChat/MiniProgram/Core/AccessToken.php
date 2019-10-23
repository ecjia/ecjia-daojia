<?php

/**
 * AccessToken.php.
 *
 */

namespace Royalcms\Component\WeChat\MiniProgram\Core;

use Royalcms\Component\WeChat\Core\AccessToken as CoreAccessToken;

/**
 * Class AccessToken.
 */
class AccessToken extends CoreAccessToken
{
    /**
     * {@inheritdoc}.
     */
    protected $prefix = 'royalcms.common.weapp.access_token.';
}
