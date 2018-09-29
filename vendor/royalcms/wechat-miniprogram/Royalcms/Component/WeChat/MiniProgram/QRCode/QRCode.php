<?php

/**
 * QRCode.php.
 *
 */

namespace Royalcms\Component\WeChat\MiniProgram\QRCode;

use Royalcms\Component\WeChat\MiniProgram\Core\AbstractMiniProgram;

class QRCode extends AbstractMiniProgram
{
    const API_GET_WXACODE = 'https://api.weixin.qq.com/wxa/getwxacode';
    const API_GET_WXACODE_UNLIMIT = 'http://api.weixin.qq.com/wxa/getwxacodeunlimit';
    const API_CREATE_QRCODE = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode';

    /**
     * Get WXACode.
     *
     * @param string $path
     * @param int    $width
     * @param bool   $autoColor
     * @param array  $lineColor
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getAppCode($path, $width = 430, $autoColor = false, $lineColor = ['r' => 0, 'g' => 0, 'b' => 0])
    {
        $params = [
            'path' => $path,
            'width' => $width,
            'auto_color' => $autoColor,
            'line_color' => $lineColor,
        ];

        return $this->getStream(self::API_GET_WXACODE, $params);
    }

    /**
     * Get WXACode unlimit.
     *
     * @param string $scene
     * @param int    $width
     * @param bool   $autoColor
     * @param array  $lineColor
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getAppCodeUnlimit($scene, $width = 430, $autoColor = false, $lineColor = ['r' => 0, 'g' => 0, 'b' => 0])
    {
        $params = [
            'scene' => $scene,
            'width' => $width,
            'auto_color' => $autoColor,
            'line_color' => $lineColor,
        ];

        return $this->getStream(self::API_GET_WXACODE_UNLIMIT, $params);
    }

    /**
     * Create QRCode.
     *
     * @param string $path
     * @param int    $width
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function createQRCode($path, $width = 430)
    {
        return $this->getStream(self::API_CREATE_QRCODE, compact('path', 'width'));
    }

    /**
     * Get stream.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function getStream($endpoint, $params)
    {
        return $this->getHttp()->json($endpoint, $params)->getBody();
    }
}
