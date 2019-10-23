<?php

namespace Royalcms\Component\WeChat\OAuth;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class OAuthServiceProvider.
 */
class OAuthServiceProvider implements ServiceProvider
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $wechat A container instance
     */
    public function register()
    {
        $wechat = $this->royalcms['wechat'];

        $wechat['oauth'] = function ($wechat) {
            $callback = $this->prepareCallbackUrl($wechat);
            $scopes = $wechat['config']->get('oauth.scopes', []);
            $socialite = with(new Socialite(
                [
                    'wechat' => [
                        'client_id' => $wechat['config']['app_id'],
                        'client_secret' => $wechat['config']['secret'],
                        'redirect' => $callback,
                    ],
                ]
            ))->driver('wechat');

            if (!empty($scopes)) {
                $socialite->scopes($scopes);
            }

            return $socialite;
        };
    }

    /**
     * Prepare the OAuth callback url for wechat.
     *
     * @param Container $pimple
     *
     * @return string
     */
    private function prepareCallbackUrl($wechat)
    {
        $callback = $wechat['config']->get('oauth.callback');
        if (0 === stripos($callback, 'http')) {
            return $callback;
        }
        $baseUrl = $wechat['request']->getSchemeAndHttpHost();

        return $baseUrl.'/'.ltrim($callback, '/');
    }
}
