<?php

/**
 * AbstractWeApp.php.
 *
 */

namespace Royalcms\Component\WeApp\Core;

use Royalcms\Component\WeChat\Core\AbstractAPI;

class AbstractWeApp extends AbstractAPI
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
     * @param \Royalcms\Component\WeApp\AccessToken $accessToken
     * @param array                               $config
     */
    public function __construct($accessToken, $config)
    {
        parent::__construct($accessToken);

        $this->config = $config;
    }
}
