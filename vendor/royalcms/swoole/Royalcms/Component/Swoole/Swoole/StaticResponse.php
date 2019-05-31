<?php

namespace Royalcms\Component\Swoole\Swoole;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;

class StaticResponse extends Response
{
    /**
     * @var BinaryFileResponse $royalcmsResponse
     */
    protected $royalcmsResponse;

    public function gzip()
    {

    }

    /**
     * @throws \Exception
     */
    public function sendContent()
    {
        /**
         * @var File $file
         */
        $file = $this->royalcmsResponse->getFile();
        $this->swooleResponse->header('Content-Type', $file->getMimeType());
        if ($this->royalcmsResponse->getStatusCode() == BinaryFileResponse::HTTP_NOT_MODIFIED) {
            $this->swooleResponse->end();
        } else {
            $path = $file->getRealPath();
            if (filesize($path) > 0) {
                if (version_compare(\swoole_version(), '1.7.21', '<')) {
                    throw new \RuntimeException('sendfile() require Swoole >= 1.7.21');
                }
                $this->swooleResponse->sendfile($path);
            } else {
                $this->swooleResponse->end();
            }
        }
    }
}