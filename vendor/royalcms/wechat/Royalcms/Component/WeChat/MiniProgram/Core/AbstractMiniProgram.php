<?php

/**
 * AbstractWeApp.php.
 *
 */

namespace Royalcms\Component\WeChat\MiniProgram\Core;

use Royalcms\Component\WeChat\Core\AbstractAPI;

class AbstractMiniProgram extends AbstractAPI
{
    /**
     * Mini program config.
     *
     * @var array
     */
    protected $config;

    /**
     * AbstractMiniProgram constructor.
     *
     * @param \Royalcms\Component\WeChat\MiniProgram\Core\AccessToken $accessToken
     * @param array                               $config
     */
    public function __construct($accessToken, $config)
    {
        parent::__construct($accessToken);

        $this->config = $config;
    }
}
